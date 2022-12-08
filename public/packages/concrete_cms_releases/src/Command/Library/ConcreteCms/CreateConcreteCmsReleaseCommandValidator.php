<?php

namespace PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms;

class CreateConcreteCmsReleaseCommandValidator extends AbstractConcreteCmsReleaseCommandValidator
{

    /**
     * @param CreateConcreteCmsReleaseCommand $command
     * @return \Concrete\Core\Error\ErrorList\ErrorList|void
     */
    public function validate($command)
    {
        $error = app('error');
        $this->validateVersionNumberFormat($error, $command);
        $this->validateVersionNumberExists($error, $command);
        return $error;
    }


}
