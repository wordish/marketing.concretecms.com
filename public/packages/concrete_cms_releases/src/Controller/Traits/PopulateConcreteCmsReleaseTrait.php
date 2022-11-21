<?php

namespace PortlandLabs\Concrete\Releases\Controller\Traits;

use PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms\CreateConcreteCmsReleaseCommand;
use PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms\CreateConcreteCmsReleaseCommandValidator;
use PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms\UpdateConcreteCmsReleaseCommand;
use PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms\UpdateConcreteCmsReleaseCommandValidator;

trait PopulateConcreteCmsReleaseTrait
{

    /**
     * @param CreateConcreteCmsReleaseCommand|UpdateConcreteCmsReleaseCommand $command
     * @param $body array The request body JSON object
     */
    protected function populateCommand($command, $body)
    {
        $isAvailableForRemoteUpdate = false;
        if (isset($body['isAvailableForRemoteUpdate']) && $body['isAvailableForRemoteUpdate'] == 1) {
            $isAvailableForRemoteUpdate = true;
        }
        $isPrerelease = false;
        if (isset($body['isPrerelease']) && $body['isPrerelease'] == 1) {
            $isPrerelease = true;
        }
        $command->setVersionNumber($body['versionNumber'] ?? '');
        $command->setReleaseDate($body['releaseDate'] ?? '');
        $command->setReleaseNotes($body['releaseNotes'] ?? '');
        $command->setMd5sum($body['md5sum'] ?? '');
        $command->setReleaseNotesUrl($body['releaseNotesUrl'] ?? '');
        $command->setDirectDownloadFile($body['directDownloadFile'] ?? 0);
        $command->setRemoteUpdaterFile($body['remoteUpdaterFile'] ?? 0);
        $command->setIsAvailableForRemoteUpdate($isAvailableForRemoteUpdate);
        $command->setIsPrerelease($isPrerelease);
    }

    protected function validateCommand($command)
    {
        if ($command instanceof CreateConcreteCmsReleaseCommand) {
            return app(CreateConcreteCmsReleaseCommandValidator::class)->validate($command);
        }
        if ($command instanceof UpdateConcreteCmsReleaseCommand) {
            return app(UpdateConcreteCmsReleaseCommandValidator::class)->validate($command);
        }
    }

}
