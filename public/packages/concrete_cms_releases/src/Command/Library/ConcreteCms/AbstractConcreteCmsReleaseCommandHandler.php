<?php

namespace PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms;

use Concrete\Core\File\File;
use Concrete\Core\Logging\LoggerAwareInterface;
use Concrete\Core\Logging\LoggerAwareTrait;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

abstract class AbstractConcreteCmsReleaseCommandHandler implements LoggerAwareInterface
{

    use LoggerAwareTrait;

    public function getLoggerChannel()
    {
        return 'concrete_cms_releases';
    }

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    protected function updateEntity(ConcreteRelease $release, $command)
    {
        $release->setVersionNumber($command->getVersionNumber());
        $release->setReleaseNotesUrl($command->getReleaseNotesUrl());
        $release->setReleaseNotes($command->getReleaseNotes());
        $release->setIsPrerelease($command->isPrerelease());
        $release->setIsAvailableForRemoteUpdate($command->isAvailableForRemoteUpdate());
        $release->setMd5sum($command->getMd5sum());

        if ($date = $command->getReleaseDate()) {
            $release->setReleaseDate(new \DateTime($date));
        }

        $release->setRemoteUpdaterFile(null);
        $release->setDirectDownloadFile(null);
        if ($command->getDirectDownloadFile()) {
            $directDownloadFile = File::getByID($command->getDirectDownloadFile());
            if ($directDownloadFile) {
                $release->setDirectDownloadFile($directDownloadFile);
            }
        }
        if ($command->getRemoteUpdaterFile()) {
            $remoteUpdaterFile = File::getByID($command->getRemoteUpdaterFile());
            if ($remoteUpdaterFile) {
                $release->setRemoteUpdaterFile($remoteUpdaterFile);
            }
        }

        $this->entityManager->persist($release);
        $this->entityManager->flush();
    }

}
