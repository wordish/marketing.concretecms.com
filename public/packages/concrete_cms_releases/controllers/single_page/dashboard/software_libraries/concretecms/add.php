<?php

namespace Concrete\Package\ConcreteCmsReleases\Controller\SinglePage\Dashboard\SoftwareLibraries\Concretecms;

use Concrete\Core\Page\Controller\DashboardPageController;
use PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms\CreateConcreteCmsReleaseCommand;
use PortlandLabs\Concrete\Releases\Controller\Traits\PopulateConcreteCmsReleaseTrait;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;
use Symfony\Component\HttpFoundation\JsonResponse;

class Add extends DashboardPageController
{

    use PopulateConcreteCmsReleaseTrait;

    public function view()
    {
        $this->requireAsset('extensions/backend');
        $this->set('backUrl', $this->app->make('url')->to('/dashboard/software_libraries/concretecms'));
        $this->set('saveUrl', $this->action('submit'));


        $release = new ConcreteRelease();
        $release->setReleaseDate(new \DateTime());
        $this->set('release', $release);
        $this->render('/dashboard/software_libraries/concretecms/form');
    }

    public function submit()
    {
        $body = json_decode($this->request->request->get('release'), true);

        $command = new CreateConcreteCmsReleaseCommand();
        $this->populateCommand($command, $body);
        $error = $this->validateCommand($command);

        if (!$this->token->validate('submit')) {
            $error->add($this->token->getErrorMessage());
        }

        if ($error->has()) {
            $this->error->add($error);
        }

        if (!$this->error->has()) {
            $release = $this->app->executeCommand($command);
            $this->flash('success', t('Concrete CMS release created successfully.'));
            return new JsonResponse($release);
        } else {
            return new JsonResponse($this->error);
        }
    }


}
