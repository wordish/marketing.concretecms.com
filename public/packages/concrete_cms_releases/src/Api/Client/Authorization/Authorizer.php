<?php

namespace PortlandLabs\Concrete\Releases\Api\Client\Authorization;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use PortlandLabs\Concrete\Releases\Api\Client\Cache\AccessTokenCache;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

final class Authorizer
{

    public function __construct(
        private Session $session,
        protected AccessTokenCache $cache,
    ) {
    }

    public function getAccessTokenCache(): AccessTokenCache
    {
        return $this->cache;
    }

    public function redirectToAuthorizationUrl(AbstractProvider $provider): RedirectResponse
    {
        $authorizationUrl = $provider->getAuthorizationUrl();
        $this->session->set('oauth2state', $provider->getState());
        return new RedirectResponse($authorizationUrl);
    }

    public function requestHasAuthorizationCode(Request $request): bool
    {
        return $request->query->has('code');
    }

    public function validateAuthorizationStateFromRequest(Request $request): bool
    {
        if (
            !$request->query->has('state')
            || !$this->session->has('oauth2state')
            || $request->query->get('state', '') !== $this->session->get('oauth2state', '')
        ) {
            return false;
        }
        return true;
    }

    public function requestNewAccessToken(
        Request $request,
        AbstractProvider $provider
    ): AccessToken {
        return $provider->getAccessToken('authorization_code', [
            'code' => $request->get('code')
        ]);
    }
}