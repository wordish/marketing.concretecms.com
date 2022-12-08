<?php

namespace Concrete\Package\ConcreteCmsReleases\Controller\SinglePage\Dashboard;

use Concrete\Core\Page\Controller\DashboardPageController;

class SoftwareLibraries extends DashboardPageController
{

    public function view()
    {
        return $this->buildRedirectToFirstAccessibleChildPage();
    }

}
