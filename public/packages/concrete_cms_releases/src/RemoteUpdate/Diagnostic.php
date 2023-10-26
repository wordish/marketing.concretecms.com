<?php

namespace PortlandLabs\Concrete\Releases\RemoteUpdate;

class Diagnostic
{

    public function __construct(
        public readonly RemoteUpdate $currentVersion,
        public readonly RemoteUpdate $requestedVersion,
    ) {
    }

}