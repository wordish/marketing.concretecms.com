<?php

namespace PortlandLabs\Concrete\Releases;

use Concrete\Core\Api\OpenApi\SourceRegistry;
use Concrete\Core\Foundation\Service\Provider;
use PortlandLabs\Concrete\Releases\Api\ApiRouteList;
use Concrete\Core\Command\Task\Manager as TaskManager;
use PortlandLabs\Concrete\Releases\Task\Controller\ImportNewReleaseController;

class ServiceProvider extends Provider
{

    public function register()
    {

        $router = $this->app->make('router');

        $list = $this->app->make(ApiRouteList::class);
        $list->loadRoutes($router);

        $this->app->make(SourceRegistry::class)->addSources([
            __DIR__ . '/Api/Controller/',
            __DIR__ . '/Api/Model/',
        ]);

        $manager = $this->app->make(TaskManager::class);
        $manager->extend('import_new_release', function () {
            return new ImportNewReleaseController();
        });

    }
}
