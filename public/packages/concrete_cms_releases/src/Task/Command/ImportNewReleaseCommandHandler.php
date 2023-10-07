<?php

namespace PortlandLabs\Concrete\Releases\Task\Command;

use Concrete\Core\Application\Application;
use Concrete\Core\Command\Task\Output\OutputAwareInterface;
use Concrete\Core\Command\Task\Output\OutputAwareTrait;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Tree\Node\Type\FileFolder;
use Doctrine\ORM\EntityManager;
use Github\Client as GitHubClient;

defined('C5_EXECUTE') or die("Access Denied.");

class ImportNewReleaseCommandHandler implements OutputAwareInterface
{
    use OutputAwareTrait;

    public function __construct(
        protected EntityManager $entityManager,
        protected Application $app,
        protected GitHubClient $gitHubClient,
        protected Repository $config,
    ) {
    }

    public function __invoke(ImportNewReleaseCommand $command)
    {
        $this->output->write(t('Importing GitHub Tag: %s', $command->tag));
        $folderId = $this->config->get('concrete_cms_releases::uploads.file_manager_folder_id');
        if (empty($folderId)) {
            throw new \Exception(t('No file manager folder location defined for release ZIP files.'));
        } else {
            $folder = FileFolder::getByID($folderId);
            if (!($folder instanceof FileFolder)) {
                throw new \Exception(t('Invalid file manager folder ID specified for release ZIP files.'));
            }
        }

        $organization = $this->config->get('concrete_cms_releases::project.organization');
        $repository = $this->config->get('concrete_cms_releases::project.repository');
        $releases = $this->gitHubClient->api('repo')->releases()->tag($organization, $repository, $command->tag);
        dd($releases);
    }


}
