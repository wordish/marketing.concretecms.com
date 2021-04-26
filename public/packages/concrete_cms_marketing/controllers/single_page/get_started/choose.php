<?php

/**
 * @project:   ConcreteCMS Theme
 *
 * @copyright  (C) 2021 Portland Labs (https://www.portlandlabs.com)
 * @author     Fabian Bitter (fabian@bitter.de)
 */

namespace Concrete\Package\ConcreteCmsMarketing\Controller\SinglePage\GetStarted;

use Concrete\Core\Form\Service\Validation;
use Concrete\Core\Http\Response;
use Concrete\Core\Http\ResponseFactory;
use Concrete\Core\Page\Controller\AccountPageController;
use Concrete\Core\Page\Page;
use Concrete\Core\Support\Facade\Url;
use Concrete\Core\User\User;

class Choose extends AccountPageController
{

    public function change_user()
    {
        /** @var ResponseFactory $responseFactory */
        $responseFactory = $this->app->make(ResponseFactory::class);
        $user = new User();
        $user->logout();
        return $responseFactory->redirect((string)Url::to("/login", "forward", Page::getCurrentPage()->getCollectionID()), Response::HTTP_TEMPORARY_REDIRECT);
    }

    public function submit()
    {
        /** @var Validation $formValidation */
        $formValidation = $this->app->make(Validation::class);

        $formValidation->setData($this->request->request->all());
        $formValidation->addRequiredToken("create_project");
        $formValidation->addRequired("projectName", t("You need to enter a valid project name."));

        if ($formValidation->test()) {
            $projectName = (string)$this->request->request->get("projectName");

            // @todo: to implement

        } else {
            $this->error = $formValidation->getError();
            $this->set('error', $formValidation->getError());
        }
    }

    public function view()
    {

    }
}