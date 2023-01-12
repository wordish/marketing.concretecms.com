<?php

namespace PortlandLabs\Concrete\Releases\Search\ConcreteRelease\ColumnSet;

use Concrete\Core\Search\Column\Set;
use PortlandLabs\Concrete\Releases\Search\ConcreteRelease\ColumnSet\Column\ReleaseDateColumn;
use PortlandLabs\Concrete\Releases\Search\ConcreteRelease\ColumnSet\Column\VersionNumberColumn;

class DefaultSet extends Set
{

    public function __construct()
    {
        $this->addColumn(new VersionNumberColumn());
        $this->addColumn(new ReleaseDateColumn());

        $date = $this->getColumnByKey('r.releaseDate');
        $this->setDefaultSortColumn($date, 'desc');
    }
}
