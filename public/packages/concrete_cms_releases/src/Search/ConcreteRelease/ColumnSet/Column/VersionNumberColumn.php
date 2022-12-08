<?php

namespace PortlandLabs\Concrete\Releases\Search\ConcreteRelease\ColumnSet\Column;

use Concrete\Core\Search\Column\Column;

class VersionNumberColumn extends Column
{
    public function getColumnKey()
    {
        return 'r.versionNumber';
    }
    
    public function getColumnName()
    {
        return t('Version Number');
    }
    
    public function getColumnCallback()
    {
        return 'getVersionNumber';
    }
}
