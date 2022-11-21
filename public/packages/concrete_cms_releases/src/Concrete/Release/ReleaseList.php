<?php

namespace PortlandLabs\Concrete\Releases\Concrete\Release;

use Concrete\Core\Search\ItemList\Database\ItemList;
use Concrete\Core\Search\Pagination\PaginationProviderInterface;
use Concrete\Core\Support\Facade\Application;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineDbalAdapter;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

class ReleaseList extends ItemList implements PaginationProviderInterface
{
    protected $autoSortColumns = ['r.versionNumber', 'r.releaseDate'];

    public function createQuery()
    {
        $this->query->select('r.*')
            ->from("ConcreteReleases", "r");
    }

    public function finalizeQuery(QueryBuilder $query)
    {
        return $query;
    }


    public function sortByReleaseDateDescending()
    {
        $this->query->orderBy('r.releaseDate', 'desc');
    }

    /**
     * @param array $queryRow
     * @return ConcreteRelease
     */
    public function getResult($queryRow)
    {
        $app = Application::getFacadeApplication();
        $entityManager = $app->make(EntityManagerInterface::class);
        return $entityManager->getRepository(ConcreteRelease::class)->findOneBy(["id" => $queryRow["id"]]);
    }

    public function getTotalResults()
    {
        return $this->deliverQueryObject()
            ->resetQueryParts(['groupBy', 'orderBy'])
            ->select('count(distinct r.id)')
            ->setMaxResults(1)
            ->execute()
            ->fetchColumn();
    }

    public function getPaginationAdapter()
    {
        return new DoctrineDbalAdapter($this->deliverQueryObject(), function ($query) {
            $query->resetQueryParts(['groupBy', 'orderBy'])
                ->select('count(distinct r.id)')
                ->setMaxResults(1);
        });
    }

}
