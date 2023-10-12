<?php

namespace PortlandLabs\Concrete\Releases\Api\Client;

use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use League\OAuth2\Client\Token\AccessToken;
use PortlandLabs\Concrete\Releases\Api\Client\Authorization\Authorizer;
use PortlandLabs\Concrete\Releases\Api\Client\Cache\AccessTokenCache;
use PortlandLabs\Concrete\Releases\Documentation\Api\Client\Provider\ConcreteCmsDocsProvider;

class ClientFactory implements ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    public function __construct(
        protected Authorizer $authorizer,
        protected ConcreteCmsDocsProvider $provider,
        protected Request $request,
    ) {
    }

    protected function getAccessToken(): ?AccessToken
    {
        $accessToken = $this->authorizer->getAccessTokenCache()->getToken($this->provider);
        if ($accessToken) {
            if (!$accessToken->hasExpired()) {
                return $accessToken;
            } else {
                $accessToken = $this->provider->getAccessToken('refresh_token', [
                    'refresh_token' => $accessToken->getRefreshToken()
                ]);
            }
        } else {
            $accessToken = $this->authorizer->requestNewAccessToken($this->request, $this->provider);
        }
        if ($accessToken) {
            $this->authorizer->getAccessTokenCache()->saveToken($this->provider, $accessToken);
        }
        return $accessToken;
    }

    public function createClient(ApiClientProviderInterface $provider): mixed
    {
        $stack = HandlerStack::create();
        $config = [
            'handler' => $stack,
            'auth' => 'oauth',
            'base_uri' => $provider->getBaseUri(),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken()
            ]
        ];
        return $provider->createClient($config);
    }
}