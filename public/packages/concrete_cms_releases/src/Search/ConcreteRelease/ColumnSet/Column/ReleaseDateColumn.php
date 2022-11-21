<?php

namespace PortlandLabs\Concrete\Releases\Search\ConcreteRelease\ColumnSet\Column;

use Concrete\Core\Search\Column\Column;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

class ReleaseDateColumn extends Column
{
    public function getColumnKey()
    {
        return 'r.releaseDate';
    }
    
    public function getColumnName()
    {
        return t('Release Date');
    }

    /**
     * @param ConcreteRelease
     * @return string
     */
    public function getColumnValue($mixed)
    {
        return $mixed->getReleaseDate('F d, Y');
    }

}
