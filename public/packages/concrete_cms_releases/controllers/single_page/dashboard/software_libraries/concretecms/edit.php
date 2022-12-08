<?php

namespace Concrete\Package\ConcreteCmsReleases\Controller\SinglePage\Dashboard\SoftwareLibraries\Concretecms;

use Concrete\Core\Page\Controller\DashboardPageController;
use PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms\UpdateConcreteCmsReleaseCommand;
use PortlandLabs\Concrete\Releases\Controller\Traits\PopulateConcreteCmsReleaseTrait;
use PortlandLabs\Concrete\Releases\Controller\Traits\RetrieveConcreteCmsReleaseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

class Edit extends DashboardPageController
{

    use RetrieveConcreteCmsReleaseTrait;
    use PopulateConcreteCmsReleaseTrait;

    public function view($id = null)
    {
        $this->requireAsset('extensions/backend');
        $release = $this->getConcreteRelease($id);
        $this->set('release', $release);
        $this->set('saveUrl', $this->action('submit', $id));
        $this->set('backUrl', $this->app->make('url')->to('/dashboard/software_libraries/concretecms/details', $id));
        $this->render('/dashboard/software_libraries/concretecms/form');
    }

    public function submit($id = null)
    {
        $release = $this->getConcreteRelease($id);
        if (!$this->token->validate("submit")) {
            $this->error->add($this->token->getErrorMessage());
        }

        if (!$this->error->has()) {
            $command = new UpdateConcreteCmsReleaseCommand($release->getId());
            $body = json_decode($this->request->request->get('release'), true);
            $this->populateCommand($command, $body);
            $error = $this->validateCommand($command);

            if ($error->has()) {
                $this->error->add($error);
            }
        }

        if (!$this->error->has()) {
            $release = $this->app->executeCommand($command);
            $this->flash('success', t('Concrete CMS release updated successfully.'));
            return new JsonResponse($release);
        } else {
            return new JsonResponse($this->error);
        }
    }



}
