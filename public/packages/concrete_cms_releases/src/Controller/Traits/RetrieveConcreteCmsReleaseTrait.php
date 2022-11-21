<?php

namespace PortlandLabs\Concrete\Releases\Controller\Traits;

use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

trait RetrieveConcreteCmsReleaseTrait
{

    protected function getConcreteRelease($id): ConcreteRelease
    {
        if ($id instanceof ConcreteRelease) {
            return $id;
        }
        $entityManager = app(EntityManager::class);
        $entry = $entityManager->find(ConcreteRelease::class, $id);
        if (!$entry) {
            throw new \Exception(t('Invalid Concrete CMS release.'));
        }
        return $entry;
    }



}
