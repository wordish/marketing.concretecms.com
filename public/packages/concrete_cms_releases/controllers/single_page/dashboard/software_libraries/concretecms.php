<?php

namespace Concrete\Package\ConcreteCmsReleases\Controller\SinglePage\Dashboard\SoftwareLibraries;

use Concrete\Core\Entity\Search\Query;
use Concrete\Core\Http\Request;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Search\Query\Modifier\AbstractRequestModifier;
use Concrete\Core\Search\Query\Modifier\AutoSortColumnRequestModifier;
use Concrete\Core\Search\Query\Modifier\ItemsPerPageRequestModifier;
use Concrete\Core\Search\Query\QueryFactory;
use Concrete\Core\Search\Query\QueryModifier;
use Concrete\Core\Search\Result\ResultFactory;
use PortlandLabs\Concrete\Releases\Search\ConcreteRelease\SearchProvider;

class Concretecms extends DashboardPageController
{

    public function view()
    {
        $provider = $this->app->make(SearchProvider::class);
        $resultFactory = $this->app->make(ResultFactory::class);
        $queryModifier = $this->app->make(QueryModifier::class);

        $query = $this->app->make(QueryFactory::class)->createQuery($provider, []);

        $queryModifier->addModifier(new AutoSortColumnRequestModifier($provider, $this->request, Request::METHOD_GET));
        $queryModifier->addModifier(new ItemsPerPageRequestModifier($provider, $this->request, Request::METHOD_GET));
        $query = $queryModifier->process($query);

        $result = $resultFactory->createFromQuery($provider, $query);
        $this->set('result', $result);
        $this->setThemeViewTemplate('full.php');
    }





}
