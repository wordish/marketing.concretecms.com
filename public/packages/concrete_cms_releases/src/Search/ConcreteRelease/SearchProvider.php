<?php

namespace PortlandLabs\Concrete\Releases\Search\ConcreteRelease;

use Concrete\Core\Search\AbstractSearchProvider;
use Concrete\Core\Search\Field\ManagerFactory;
use PortlandLabs\Concrete\Releases\Concrete\Release\ReleaseList;
use PortlandLabs\Concrete\Releases\Search\ConcreteRelease\ColumnSet\DefaultSet;
use PortlandLabs\Concrete\Releases\Search\ConcreteRelease\Result\Result;

class SearchProvider extends AbstractSearchProvider
{
    public function getFieldManager()
    {
        return ManagerFactory::get('extension_collection');
    }
    
    public function getSessionNamespace()
    {
        return null; // not used
    }
    
    public function getCustomAttributeKeys()
    {
        return []; // not used
    }
    
    public function getBaseColumnSet()
    {
        return new DefaultSet();
    }
    
    public function getAvailableColumnSet()
    {
        return new DefaultSet();
    }
    
    public function getCurrentColumnSet()
    {
        return false; // not used
    }
    
    public function createSearchResultObject($columns, $list)
    {
        return new Result($columns, $list);
    }
    
    public function getItemList()
    {
        return new ReleaseList();
    }
    
    public function getDefaultColumnSet()
    {
        return new DefaultSet();
    }
    
    public function getSavedSearch()
    {
        return null; // not used
    }
}
