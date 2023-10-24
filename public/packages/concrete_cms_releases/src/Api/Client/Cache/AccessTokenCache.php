<?php

namespace PortlandLabs\Concrete\Releases\Api\Client\Cache;

use Concrete\Core\Application\Application;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use PortlandLabs\Concrete\Releases\Api\Client\ApiClientProviderInterface;

class AccessTokenCache
{

    protected $config;

    public function __construct(
        protected Application $app
    )
    {
        $this->config = $this->app->make('config/database');
    }

    protected function getCacheKey(ApiClientProviderInterface $provider): string
    {
        return sprintf('oauth2.access.token.%s', $provider->getAccessTokenCacheKey());
    }

    public function saveToken(ApiClientProviderInterface $provider, AccessToken $accessToken): void
    {
        $this->config->save($this->getCacheKey($provider), serialize($accessToken));
    }

    public function clearToken(ApiClientProviderInterface $provider)
    {
        $this->config->save($this->getCacheKey($provider), null);
    }

    public function getToken(ApiClientProviderInterface $provider): ?AccessToken
    {
        $accessTokenValue = $this->config->get($this->getCacheKey($provider));
        if ($accessTokenValue) {
            $accessToken = unserialize($accessTokenValue);
            if ($accessToken instanceof AccessToken) {
                return $accessToken;
            }
        }
        return null;
    }


}