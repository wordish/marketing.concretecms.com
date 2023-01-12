<?php

namespace PortlandLabs\Concrete\Releases\Search\ConcreteRelease\Result;

use Concrete\Core\Search\Column\Set;
use Concrete\Core\Search\Result\Item as SearchResultItem;
use Concrete\Core\Search\Result\Result as SearchResult;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

class Item extends SearchResultItem
{
    public $id;
    
    public function __construct(SearchResult $result, Set $columns, $item)
    {
        parent::__construct($result, $columns, $item);
        $this->populateDetails($item);
    }
    
    /**
    * @param ConcreteRelease $item
    */
    protected function populateDetails($item)
    {
        $this->id = $item->getId();
    }

    public function getDetailsURL()
    {
        return \URL::to('/dashboard/software_libraries/concretecms/details', $this->item->getId());
    }
}
