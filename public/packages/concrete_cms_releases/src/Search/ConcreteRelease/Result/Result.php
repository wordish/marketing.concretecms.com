<?php

namespace PortlandLabs\Concrete\Releases\Search\ConcreteRelease\Result;

use Concrete\Core\Search\Result\Result as SearchResult;

class Result extends SearchResult
{
    public function getItemDetails($item)
    {
        return new Item($this, $this->listColumns, $item);
    }
    
    public function getColumnDetails($column)
    {
        return new Column($this, $column);
    }
}
