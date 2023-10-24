<?php

namespace PortlandLabs\Concrete\Releases\RemoteUpdate;

use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

class DiagnosticFactory
{

    public function __construct(
        protected EntityManager $entityManager
    ) {
    }

    /**
     * Given the version of Concrete on a particular site, creates a remote update available for
     * that site.
     *
     * @param ConcreteRelease $currentVersion
     * @return Diagnostic
     */
    public function createFromCurrentAndRequestedRelease(
        ConcreteRelease $currentRelease,
        ConcreteRelease $requestedRelease
    ): Diagnostic {
        $diagnostic = new Diagnostic(new RemoteUpdate($currentRelease), new RemoteUpdate($requestedRelease));
        return $diagnostic;
    }

}