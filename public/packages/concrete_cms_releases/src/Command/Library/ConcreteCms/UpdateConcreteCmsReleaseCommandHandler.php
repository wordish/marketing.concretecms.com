<?php

namespace PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms;

use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

class UpdateConcreteCmsReleaseCommandHandler extends AbstractConcreteCmsReleaseCommandHandler
{

    public function __invoke(UpdateConcreteCmsReleaseCommand $command)
    {
        $release = $this->entityManager->find(ConcreteRelease::class, $command->getId());
        $this->updateEntity($release, $command);
        return $release;
    }

    
}
