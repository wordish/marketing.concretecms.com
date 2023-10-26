<?php

namespace PortlandLabs\Concrete\Releases\Api\Client\Resources;

use PortlandLabs\Concrete\Releases\Api\Client\Client;

abstract class AbstractResource
{

    public function __construct(
        protected Client $client
    ) {
    }

}