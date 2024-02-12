<?php

namespace PortlandLabs\Concrete\Releases\Task\Command;

use Composer\Semver\VersionParser;
use Concrete\Core\Application\Application;
use Concrete\Core\Command\Task\Output\OutputAwareInterface;
use Concrete\Core\Command\Task\Output\OutputAwareTrait;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Entity\File\Version;
use Concrete\Core\File\Import\FileImporter;
use Concrete\Core\File\Import\ImportOptions;
use Concrete\Core\File\Service\VolatileDirectory;
use Concrete\Core\Tree\Node\Type\FileFolder;
use Doctrine\ORM\EntityManager;
use Github\Client as GitHubClient;
use GuzzleHttp\Client as GuzzleClient;
use PortlandLabs\Concrete\Releases\Api\Client\Client as ReleasesApiClient;
use PortlandLabs\Concrete\Releases\Api\Client\ClientFactory;
use PortlandLabs\Concrete\Releases\Documentation\Api\Client\Provider\ConcreteCmsDocsProvider;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

defined('C5_EXECUTE') or die("Access Denied.");

class ImportNewReleaseCommandHandler implements OutputAwareInterface
{
    use OutputAwareTrait;

    private const ASSET_LABEL_ARCHIVE = 'archive';
    private const ASSET_LABEL_REMOTE_UPDATE_ARCHIVE = 'remote-updater';

    public function __construct(
        private EntityManager $entityManager,
        private Application $app,
        private GitHubClient $gitHubClient,
        private VolatileDirectory $volatileDirectory,
        private Repository $config,
        private FileImporter $fileImporter,
        private ConcreteCmsDocsProvider $docsProvider,
        private ClientFactory $clientFactory,
        private GuzzleClient $guzzleClient
    ) {
    }

    /**
     * Takes release data from GitHub and validates that this release can be imported into our releases data store.
     * @param array $release
     * @return void
     */
    private function validateRelease(array $release): void
    {
        $foundArchive = false;
        $foundRemoteArchive = false;
        foreach ((array)$release['assets'] as $asset) {
            $assetLabel = $asset['label'] ?? null;
            if ($assetLabel === self::ASSET_LABEL_ARCHIVE) {
                $foundArchive = true;
            }
            if ($assetLabel === self::ASSET_LABEL_REMOTE_UPDATE_ARCHIVE) {
                $foundRemoteArchive = true;
            }
        }
        if (!$foundArchive) {
            throw new \Exception(
                t(
                    'Unable to locate downloadable archive for the release. 
This is a release asset joined to the GitHub release object with the label "%s"',
                    self::ASSET_LABEL_ARCHIVE
                )
            );
        }
        if (!$foundRemoteArchive) {
            throw new \Exception(
                t(
                    'Unable to locate remote updater archive for the release. 
This is a release asset joined to the GitHub release object with the label "%s"',
                    self::ASSET_LABEL_REMOTE_UPDATE_ARCHIVE
                )
            );
        }
        $localRelease = $this->entityManager->getRepository(ConcreteRelease::class)
            ->findOneByVersionNumber($release['tag_name']);
        if ($localRelease) {
            throw new \Exception(
                t(
                    'A release with the version number matching tag named "%s" already exists. Aborting....',
                    $release['tag_name']
                )
            );
        }
    }

    private function validateAndRetrieveFileFolder(): FileFolder
    {
        $folderId = $this->config->get('concrete_cms_releases::uploads.file_manager_folder_id');
        if (empty($folderId)) {
            throw new \Exception(t('No file manager folder location defined for release ZIP files.'));
        } else {
            $folder = FileFolder::getByID($folderId);
            if (!($folder instanceof FileFolder)) {
                throw new \Exception(t('Invalid file manager folder ID specified for release ZIP files.'));
            }
        }
        return $folder;
    }

    private function copyReleaseAssetToFolder(array $release, string $assetLabel, FileFolder $folder): Version
    {
        $path = $this->volatileDirectory->getPath();
        foreach ((array)$release['assets'] as $asset) {
            if ($asset['label'] === $assetLabel) {
                $this->output->write(
                    t(
                        'Downloading URL "%s" for asset label "%s" to "%s"',
                        $asset['browser_download_url'],
                        $assetLabel,
                        $path,
                    )
                );
                $file = $path . '/' . $asset['name'];
                $this->guzzleClient->get($asset['browser_download_url'], [
                    'sink' => $file,
                ]);
                $this->output->write(t('Importing file into file manager...'));
                $options = $this->app->make(ImportOptions::class);
                $options->setImportToFolder($folder);
                return $this->fileImporter->importLocalFile($file, $asset['name'], $options);
            }
        }
    }

    private function validateAndRetrieveRelease(string $tagName): array
    {
        $organization = $this->config->get('concrete_cms_releases::project.organization');
        $repository = $this->config->get('concrete_cms_releases::project.repository');
        $release = $this->gitHubClient->api('repo')->releases()->tag($organization, $repository, $tagName);
        if (!$release) {
            throw new \Exception(t('Unable to locate release for this tag.'));
        }
        $this->validateRelease($release);
        return $release;
    }

    private function getVersionHistoryParentPageIdForRelease($release): ?int
    {
        $parentIdArray = $this->config->get(
            'concrete_cms_releases::version_history.version_history_parent_page_id'
        ) ?? [];
        $majorVersion = explode('.', $release['tag_name'])[0] ?? null;
        if ($majorVersion) {
            if (isset($parentIdArray[$majorVersion])) {
                return $parentIdArray[$majorVersion];
            }
        }
        return null;
    }

    private function createReleaseNotes(ReleasesApiClient $client, $release): array
    {
        $parentId = $this->getVersionHistoryParentPageIdForRelease($release);
        $requestBody = [
            'parent' => $parentId,
            'type' => 'developer_document',
            'template' => 'document',
            'name' => sprintf('%s Release Notes', $release['name']),
        ];
        $addPageResponse = $client->pages()->add($requestBody);

        $requestBody = [
            'type' => 'markdown',
            'value' => [
                'content' => $release['body']
            ],
        ];
        $addBlockResponse = $client->pages()->addBlock($addPageResponse['id'], 'Main', $requestBody);

        $approvalBody = [
            'is_approved' => true
        ];

        $response = $client->versions()->update(
            $addPageResponse['id'],
            $addBlockResponse['page']['data']['version']['data']['id'],
            $approvalBody
        );

        return $addPageResponse;
    }

    private function validateVersionHistoryPublishingAndRetrieveResourceOwner(ReleasesApiClient $client, $release): array
    {
        $parentId = $this->getVersionHistoryParentPageIdForRelease($release);
        if (empty($parentId)) {
            throw new \Exception(t('No version history parent ID defined for release notes.'));
        }
        return $client->account()->read();
    }

    public function __invoke(ImportNewReleaseCommand $command)
    {
        $this->output->write(t('Validating GitHub Tag as Release: %s', $command->tag));

        $folder = $this->validateAndRetrieveFileFolder();
        $release = $this->validateAndRetrieveRelease($command->tag);

        $this->output->write(t('Release found to be valid and has not yet been created locally. Ready to import!'));

        if ($command->skipReleaseNotes) {
            $this->output->write(t('Release note posting SKIPPED!'));
        } else {
            $this->output->write(t('Validating connected documentation user.'));
            $client = $this->clientFactory->createClient($this->docsProvider);
            $docsResourceOwner = $this->validateVersionHistoryPublishingAndRetrieveResourceOwner(
                $client,
                $release
            );
            if ($docsResourceOwner) {
                $this->output->write(
                    t(
                        'Successfully connected to %s. Docs will be posted on behalf of user %s (%s). Make sure this user has permission to post documentation to the website.',
                        $_ENV['URL_SITE_DOCUMENTATION'],
                        $docsResourceOwner['username'],
                        $docsResourceOwner['email'],
                    )
                );
            }
            $releaseNotesResponse = $this->createReleaseNotes($client, $release);
        }


        $archiveFileVersion = $this->copyReleaseAssetToFolder($release, self::ASSET_LABEL_ARCHIVE, $folder);
        $archiveRemoteUpdaterFileVersion = $this->copyReleaseAssetToFolder(
            $release,
            self::ASSET_LABEL_REMOTE_UPDATE_ARCHIVE,
            $folder
        );


        $concreteRelease = new ConcreteRelease();
        $concreteRelease->setReleaseDate(new \DateTime($release['published_at']));
        $concreteRelease->setReleaseNotes($release['body']);
        $concreteRelease->setDirectDownloadFile($archiveFileVersion->getFile());
        $concreteRelease->setRemoteUpdaterFile($archiveRemoteUpdaterFileVersion->getFile());
        $concreteRelease->setVersionNumber($release['name']);
        $concreteRelease->setVersionName($release['name']);
        $concreteRelease->setIsPrerelease(false);

        // Handle md5
        $archiveFile = $archiveFileVersion->getFile();
        $storageLocation = $archiveFile->getFileStorageLocationObject();
        $concreteRelease->setMd5sum(
            md5_file(
                $storageLocation->getConfigurationObject()->getRootPath()
                . '/' . $archiveFile->getFileResource()->getPath()
            )
        );

        $versionParser = new VersionParser();
        $version = $versionParser->normalize($command->tag);
        $versionParts = explode('.', $version);
        if (isset($versionParts[2]) && is_numeric($versionParts[2]) && $versionParts[2] > 0) {
            // This is a patch version, which defaults to available to remote update.
            $this->output->write('Patch version string found. Setting remote update to true.');
            $concreteRelease->setIsAvailableForRemoteUpdate(true);
        } else {
            $this->output->write('Non-patch version string found. Setting remote update to false.');
            $concreteRelease->setIsAvailableForRemoteUpdate(false);
        }

        if (!$command->skipReleaseNotes) {
            $concreteRelease->setReleaseNotesUrl($_ENV['URL_SITE_DOCUMENTATION'] . $releaseNotesResponse['path']);
        }

        $this->entityManager->persist($concreteRelease);
        $this->entityManager->flush();

        $this->output->write(
            t(
                'Concrete Release Created! ID: %s, Name/Version %s',
                $concreteRelease->getId(),
                $concreteRelease->getVersionNumber()
            )
        );
    }


}
