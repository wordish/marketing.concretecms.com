<?php

namespace PortlandLabs\ConcreteCmsMarketing;

use Concrete\Core\Foundation\Service\Provider;
use Concrete\Core\Routing\Router;

class ServiceProvider extends Provider
{

    public function register()
    {
        $this->registerRemoteActivitySlots();
    }

    /**
     * This handles what used to be handled by newsflow on the old site – a simple place for admins to define blocks in
     * stacks for remote featured content.
     */
    protected function registerRemoteActivitySlots()
    {
        $router = $this->app->make(Router::class);
        $router->get('/ccm/marketing/activity_slots', 'Concrete\Package\ConcreteCmsMarketing\Controller\RemoteActivity::view');

    }

}
