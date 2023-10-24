<?php

namespace Concrete\Package\ConcreteCmsReleases\Block\DownloadConcreteRelease;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Http\Client\Client;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

class Controller extends BlockController
{
    protected $btTable = "btDownloadConcreteRelease";
    protected $btIgnorePageThemeGridFrameworkContainer = true;

    protected const RELEASE_TYPE_IDENTIFIER_SPECIFIC_RELEASE = 'S';
    protected const RELEASE_TYPE_IDENTIFIER_LATEST_RELEASE_BRANCH = 'B';
    protected const RELEASE_TYPE_IDENTIFIER_LATEST_RELEASE_ALL = 'L';

    public $releaseID;
    public $downloadReleaseType;
    public $latestVersionSpecificBranchIdentifier;

    public function getBlockTypeDescription()
    {
        return t('Links to a Concrete release for download.');
    }

    public function getBlockTypeName()
    {
        return t('Download Concrete Release');
    }

    protected function loadReleases()
    {
        $releases = $this->app->make(EntityManager::class)->getRepository(ConcreteRelease::class)->findBy([],
            ['releaseDate' => 'desc']);
        $this->set('releases', $releases);
    }

    public function add()
    {
        $this->loadReleases();
        $this->set('latestVersionSpecificBranchIdentifier', '9');
        $this->set('downloadReleaseType', self::RELEASE_TYPE_IDENTIFIER_SPECIFIC_RELEASE);
        $this->set('releaseID', '');
    }

    public function view()
    {
        $releases = $this->app->make(EntityManager::class)->getRepository(ConcreteRelease::class)->findAllSortedByVersionNumber();
        $downloadReleaseType = $this->downloadReleaseType ?? self::RELEASE_TYPE_IDENTIFIER_SPECIFIC_RELEASE;
        if ($downloadReleaseType === self::RELEASE_TYPE_IDENTIFIER_SPECIFIC_RELEASE) {
            $this->set(
                'release',
                $this->app->make(EntityManager::class)->find(ConcreteRelease::class, $this->releaseID)
            );
        } else if ($downloadReleaseType === self::RELEASE_TYPE_IDENTIFIER_LATEST_RELEASE_BRANCH) {
            foreach ($releases as $release) {
                $majorVersion = explode('.', $release->getVersionNumber())[0];
                if ($majorVersion === $this->latestVersionSpecificBranchIdentifier) {
                    $this->set('release', $release);
                    break;
                }
            }
        } elseif ($downloadReleaseType === self::RELEASE_TYPE_IDENTIFIER_LATEST_RELEASE_ALL) {
            foreach ($releases as $release) {
                if (!$release->isPreRelease()) {
                    $this->set('release', $release);
                    break;
                }
            }
        }
    }

    public function save($args)
    {
        $data = [];
        $downloadReleaseType = $args['downloadReleaseType'] ??
            self::RELEASE_TYPE_IDENTIFIER_SPECIFIC_RELEASE;
        $data['downloadReleaseType'] = $args['downloadReleaseType'];
        $data['releaseID'] = '';
        if ($downloadReleaseType === self::RELEASE_TYPE_IDENTIFIER_SPECIFIC_RELEASE) {
            $releaseID = $args['releaseID'] ?? null;
            $release = $this->app->make(EntityManager::class)->find(ConcreteRelease::class, $releaseID);
            if ($release) {
                $data['releaseID'] = $release->getId();
            } else {
                throw new \RuntimeException(t('You must specify a specific release.'));
            }
        } elseif ($downloadReleaseType === self::RELEASE_TYPE_IDENTIFIER_LATEST_RELEASE_BRANCH) {
            $data['latestVersionSpecificBranchIdentifier'] = $args['latestVersionSpecificBranchIdentifier'];
        }
        return parent::save($data);
    }

    public function edit()
    {
        $this->loadReleases();
    }
}
