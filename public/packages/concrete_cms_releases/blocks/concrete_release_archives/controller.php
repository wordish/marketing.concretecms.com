<?php

namespace Concrete\Package\ConcreteCmsReleases\Block\ConcreteReleaseArchives;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Http\Client\Client;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

class Controller extends BlockController
{
    public function getBlockTypeDescription()
    {
        return t('Shows a list of all Concrete version releases.');
    }

    public function getBlockTypeName()
    {
        return t('Concrete Release Archives');
    }

    public function view()
    {
        $releases = $this->app->make(EntityManager::class)->getRepository(ConcreteRelease::class)->findBy([],
            ['releaseDate' => 'desc']);
        $this->set('releases', $releases);

    }

}
