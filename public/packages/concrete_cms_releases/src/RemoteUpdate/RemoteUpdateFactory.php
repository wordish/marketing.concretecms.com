<?php

namespace PortlandLabs\Concrete\Releases\RemoteUpdate;

use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

class RemoteUpdateFactory
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
     * @return RemoteUpdate
     */
    public function createFromCurrentRelease(ConcreteRelease $currentRelease): RemoteUpdate
    {
        $releases = $this->entityManager->getRepository(ConcreteRelease::class)
            ->findAllSortedByVersionNumber();

        // Now that we have all our releases sorted by release date, extract the slice of releases after
        // the one that matches our current release.
        $releaseSlice = [];
		foreach($releases as $v) {
			if (version_compare($v->getVersionNumber(), $currentRelease->getVersionNumber(), '<=')) {
                continue;
			}
            $releaseSlice[] = $v;
		}

        // Now we have a slice of releases that are all the releases after the current release they're upgrading
        // from. So let's move _backwards_ through that slice to find the first release that is available for
        // remote update.
        // First that means we have to reverse the order. Yes, I know we could do this with a for loop and count
        // backwards but this is easier to understand imho.
        $releaseSlice = array_reverse($releaseSlice);
        $pruneFromEnd = 0;
        foreach ($releaseSlice as $v) {
            if ($v->isAvailableForRemoteUpdate()) {
                break;
            }
            $pruneFromEnd++;
        }

        // Now flip it back.
        $releaseSlice = array_reverse($releaseSlice);
        if ($pruneFromEnd > 0) {
            array_splice($releaseSlice, 0 - $pruneFromEnd);
        }

        $updateToVersion = end($releaseSlice) ?? null;
        if ($updateToVersion) {
            return new RemoteUpdate($updateToVersion, $releaseSlice);
        }
    }

}