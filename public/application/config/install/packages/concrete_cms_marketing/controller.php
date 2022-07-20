<?php

namespace Application\StartingPointPackage\ConcreteCmsMarketing;

use Concrete\Core\Application\Application;
use Concrete\Core\Backup\ContentImporter;
use Concrete\Core\Package\Routine\AttachModeInstallRoutine;
use Concrete\Core\Package\StartingPointInstallRoutine;
use Concrete\Core\Package\StartingPointPackage;

class Controller extends StartingPointPackage
{
    protected $pkgHandle = 'concrete_cms_marketing';

    public function getPackageName()
    {
        return t('marketing.concretecms.com');
    }

    public function getPackageDescription()
    {
        return 'Installs the marketing.concretecms.com starting point.';
    }
}
