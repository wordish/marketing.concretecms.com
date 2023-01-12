<?php

namespace PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms;

use Concrete\Core\Logging\LoggerAwareInterface;
use Concrete\Core\Logging\LoggerAwareTrait;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete\Releases\Controller\Traits\RetrieveConcreteCmsReleaseTrait;

class DeleteConcreteCmsReleaseCommandHandler implements LoggerAwareInterface
{

    use LoggerAwareTrait;
    use RetrieveConcreteCmsReleaseTrait;

    public function getLoggerChannel()
    {
        return 'concrete_cms_releases';
    }

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param DeleteConcreteCmsReleaseCommand $command
     */
    public function __invoke($command)
    {
        $release = $this->getConcreteRelease($command->getId());

        $this->logger->alert(
            t('Concrete CMS release %s (ID %s) deleted', $release->getVersionNumber(), $release->getID()),
            ['release' => $release]
        );

        $this->entityManager->remove($release);
        $this->entityManager->flush();
        return $release;
    }

    
}
