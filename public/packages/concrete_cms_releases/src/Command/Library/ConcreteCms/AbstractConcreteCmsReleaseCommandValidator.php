<?php

namespace PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms;

use Composer\Semver\VersionParser;
use Concrete\Core\Error\ErrorList\ErrorList;
use Concrete\Core\Foundation\Command\ValidatorInterface;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

abstract class AbstractConcreteCmsReleaseCommandValidator implements ValidatorInterface
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var VersionParser
     */
    protected $versionParser;

    public function __construct(VersionParser $versionParser, EntityManager $entityManager)
    {
        $this->versionParser = $versionParser;
        $this->entityManager = $entityManager;
    }

    protected function validateVersionNumberFormat(ErrorList $error, $command)
    {
        try {
            $version = $this->versionParser->normalize($command->getVersionNumber());
        } catch (\Exception $e) {
            $error->add(
                t('Unable to parse Concrete CMS version. You must specify a valid semver version for this release.'),
                'versionNumber'
            );
        }
    }

    protected function validateVersionNumberExists(ErrorList $error, $command)
    {
        if ($command instanceof UpdateConcreteCmsReleaseCommand) {
            $currentRelease = $this->entityManager->find(ConcreteRelease::class, $command->getId());
            if ($currentRelease->getVersionNumber() == $command->getVersionNumber()) {
                return;
            }
        }

        $existingRelease = $this->entityManager->getRepository(ConcreteRelease::class)
            ->findOneByVersionNumber(trim($command->getVersionNumber()));
        if ($existingRelease) {
            $error->add(t('A release with this version number already exists.'), 'versionNumber');
        }
    }

}
