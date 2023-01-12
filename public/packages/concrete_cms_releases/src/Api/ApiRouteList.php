<?php

namespace PortlandLabs\Concrete\Releases\Api;

use Concrete\Core\Routing\RouteListInterface;
use Concrete\Core\Routing\Router;
use Doctrine\DBAL\Connection;
use PortlandLabs\Concrete\Releases\Api\Controller\ConcreteReleases;

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
        $router->get('/api/1.0/libraries/releases/concretecms', [ConcreteReleases::class, 'getList']);
        $router->get('/api/1.0/libraries/releases/concretecms/{releaseId}', [ConcreteReleases::class, 'getRelease']);
    }

}