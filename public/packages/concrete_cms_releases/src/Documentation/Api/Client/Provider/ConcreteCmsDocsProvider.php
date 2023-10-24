<?php

namespace PortlandLabs\Concrete\Releases\Documentation\Api\Client\Provider;

use Concrete\OAuth2\Client\Provider\ConcreteCms\Version92;
use PortlandLabs\Concrete\Releases\Api\Client\ApiClientProviderInterface;
use PortlandLabs\Concrete\Releases\Api\Client\Client;

class ConcreteCmsDocsProvider extends Version92 implements ApiClientProviderInterface
{

    public function getAccessTokenCacheKey(): string
    {
        return 'concrete_cms_docs';
    }

    public function getBaseUri(): string
    {
        return $this->baseUrl;
    }

    public function __construct(string $redirectUri = '')
    {
        $this->clientId = $_ENV['DOCUMENTATION_API_CLIENT_ID'];
        $this->clientSecret = $_ENV['DOCUMENTATION_API_CLIENT_SECRET'];
        $this->redirectUri = $redirectUri;
        $this->baseUrl = $_ENV['URL_SITE_DOCUMENTATION'];
        parent::__construct();
    }

    public function getDefaultScopes()
    {
        $scopes = parent::getDefaultScopes();
        $scopes[] = 'pages:add';
        $scopes[] = 'pages:areas:add_block';
        $scopes[] = 'pages:versions:update';
        return $scopes;
    }

    public function createClient(array $config): Client
    {
        return new Client($config);
    }
}