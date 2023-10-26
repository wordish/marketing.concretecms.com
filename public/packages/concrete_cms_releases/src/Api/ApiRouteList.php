<?php

namespace PortlandLabs\Concrete\Releases\Api;

use Concrete\Core\Routing\RouteListInterface;
use Concrete\Core\Routing\Router;
use Doctrine\DBAL\Connection;
use PortlandLabs\Concrete\Releases\Api\Controller\ConcreteReleases;
use PortlandLabs\ConcreteCmsTheme\API\V1\Middleware\FractalNegotiatorMiddleware;

class ApiRouteList implements RouteListInterface
{

    /**
     * @var Connection
     */
    protected $db;

    /**
     * ApiRouteList constructor.
     * @param Connection $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function loadRoutes(Router $router)
    {
        $router->buildGroup()->addMiddleware(FractalNegotiatorMiddleware::class)
            ->routes( function($router) {
                $router->get('/api/1.0/libraries/releases/concretecms', [ConcreteReleases::class, 'getList']);
                $router->get('/api/1.0/libraries/releases/concretecms/{releaseId}', [ConcreteReleases::class, 'getRelease']);
                $router->get('/api/1.0/libraries/releases/concretecms/getByVersionNumber/{version}', [ConcreteReleases::class, 'getByVersionNumber']);

                // Power the built-in updater found in Concrete CMS. This is old and needs to be
                // backward compatible so it has a slightly out-of-favor syntax and naming.
                $router->all('/api/remote_update/update_core', [ConcreteReleases::class, 'getRemoteUpdateReleaseInformation']);
                $router->post('/api/remote_update/inspect_update', [ConcreteReleases::class, 'inspectRemoteUpdate']);

                // Download latest.zip
                $router->get('/download/latest.zip', [ConcreteReleases::class, 'downloadLatest']);
            });
    }

}