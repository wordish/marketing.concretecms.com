<?php

namespace PortlandLabs\Concrete\Releases\RemoteUpdate;

use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

/**
 * A decorator for the release that adds some additional fields - most notably the combined release notes
 * of all relevant releases.
 */
class RemoteUpdate
{

    public function __construct(
        public readonly ConcreteRelease $release,
        public readonly array $releaseRange = []
    ) {
    }

    public function __call($name, $arguments)
    {
        return $this->release->$name(...$arguments);
    }

    public function getAllFormattedReleaseNotes(): string
    {
        if (count($this->releaseRange) === 0) {
            return $this->release->getFormattedReleaseNotes();
        } else {
            $return = '';
            foreach ($this->releaseRange as $release) {
                $return .= '<h1>' . $release->getVersionNumber() . '</h1>';
                $return .= $release->getFormattedReleaseNotes();
            }
            return $return;
        }
    }
}