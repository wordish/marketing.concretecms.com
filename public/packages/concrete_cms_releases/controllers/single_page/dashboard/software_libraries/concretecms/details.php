<?php

namespace Concrete\Package\ConcreteCmsReleases\Controller\SinglePage\Dashboard\SoftwareLibraries\Concretecms;

use Concrete\Core\Page\Controller\DashboardPageController;
use PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms\DeleteConcreteCmsReleaseCommand;
use PortlandLabs\Concrete\Releases\Controller\Traits\RetrieveConcreteCmsReleaseTrait;

class Details extends DashboardPageController
{

    use RetrieveConcreteCmsReleaseTrait;

    public function view($id = null)
    {
        $this->requireAsset('extensions/backend');
        $release = $this->getConcreteRelease($id);
        $this->set('release', $release);
        $this->set('backURL', \URL::to('/dashboard/software_libraries/concretecms'));
        $this->set('editURL', \URL::to('/dashboard/software_libraries/concretecms/edit', $release->getID()));
        $this->set('allowDelete', true);
    }

    public function delete($id = null)
    {
        $collection = $this->getConcreteRelease($id);
        if (!$this->token->validate("delete")) {
            $this->error->add($this->token->getErrorMessage());
        }

        if (!$this->error->has()) {
            $command = new DeleteConcreteCmsReleaseCommand($collection->getId());
            $this->executeCommand($command);
            $this->flash('success', t('Concrete CMS release removed successfully.'));
            return $this->buildRedirect(['/dashboard/software_libraries/concretecms']);
        }
        $this->view($id);
    }



}
