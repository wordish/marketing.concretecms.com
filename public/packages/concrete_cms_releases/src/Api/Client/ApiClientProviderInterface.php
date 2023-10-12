<?php

namespace PortlandLabs\Concrete\Releases\Api\Client;

interface ApiClientProviderInterface
{

    public function getAccessTokenCacheKey(): string;

    public function getBaseUri(): string;

    public function createClient(array $config): Client;

}