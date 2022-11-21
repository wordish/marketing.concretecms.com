<?php

namespace PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms;

use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

class CreateConcreteCmsReleaseCommandHandler extends AbstractConcreteCmsReleaseCommandHandler
{

    public function __invoke(CreateConcreteCmsReleaseCommand $command)
    {
        $release = new ConcreteRelease();
        $this->updateEntity($release, $command);
        return $release;
    }

    
}
