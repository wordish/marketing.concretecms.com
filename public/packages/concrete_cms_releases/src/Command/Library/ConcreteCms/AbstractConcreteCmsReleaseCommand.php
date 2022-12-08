<?php

namespace PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms;

use Concrete\Core\Foundation\Command\Command;

abstract class AbstractConcreteCmsReleaseCommand extends Command
{

    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    

}
