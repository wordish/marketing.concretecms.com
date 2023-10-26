<?php

namespace Concrete\Package\ConcreteCmsReleases\Controller\SinglePage\Dashboard\SoftwareLibraries;

use Concrete\Core\Page\Controller\DashboardPageController;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use PortlandLabs\Concrete\Releases\Api\Client\Authorization\Authorizer;
use PortlandLabs\Concrete\Releases\Api\Client\ClientFactory;
use PortlandLabs\Concrete\Releases\Documentation\Api\Client\Provider\ConcreteCmsDocsProvider;

class Settings extends DashboardPageController
{

    public function view()
    {
        try {
            $provider = $this->app->make(ConcreteCmsDocsProvider::class);
            $client = $this->app->make(ClientFactory::class)->createClient($provider);
            $resourceOwner = $client->account()->read();
            $this->set('resourceOwner', $resourceOwner);
        } catch (\Exception $e) {
            // Unable to connect, we either haven't authorized an access token or something has changed.
        }
    }

    public function reset()
    {
        $authorizer = $this->app->make(Authorizer::class);
        if (!$this->token->validate('reset')) {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has()) {
            $provider = $this->app->make(ConcreteCmsDocsProvider::class);
            $authorizer->getAccessTokenCache()->clearToken($provider);
        }
        $this->view();
    }
    public function authorize()
    {
        $provider = $this->app->make(ConcreteCmsDocsProvider::class);
        $authorizer = $this->app->make(Authorizer::class);
        if (!$authorizer->requestHasAuthorizationCode($this->request)) {
            return $authorizer->redirectToAuthorizationUrl($provider);
        } elseif (!$authorizer->validateAuthorizationStateFromRequest($this->request)) {
            $this->error->add(t('Invalid OAuth2 State. Please try again.'));
        } else {
            try {
                $clientFactory = $this->app->make(ClientFactory::class);
                $client = $clientFactory->createClient($provider);
                $resourceOwner = $client->account()->read();
                if ($resourceOwner) {
                    $this->flash('success', t('API connection created successfully.'));
                    return $this->buildRedirect($this->action('view'));
                }
            } catch (IdentityProviderException $e) {
                $this->error->add($e);
            }
        }
    }


}
