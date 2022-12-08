<?php

namespace PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms;

class UpdateConcreteCmsReleaseCommandValidator extends AbstractConcreteCmsReleaseCommandValidator
{

    /**
     * @param UpdateConcreteCmsReleaseCommand $command
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
