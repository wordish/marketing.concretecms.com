<?php

namespace PortlandLabs\Concrete\Releases\Entity;

use Doctrine\ORM\EntityRepository;

class ConcreteReleaseRepository extends EntityRepository
{

    public function findAllSortedByVersionNumber()
    {
        $releases = $this->findAll();
        usort($releases, function($a, $b) {
            return version_compare($b->getVersionNumber(), $a->getVersionNumber());
        });
        return $releases;
    }
}