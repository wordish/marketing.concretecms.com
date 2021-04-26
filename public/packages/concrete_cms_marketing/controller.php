<?php

namespace Concrete\Package\ConcreteCmsMarketing;

use Concrete\Core\Package\Package;

class Controller extends Package
{

    protected $pkgHandle = 'concrete_cms_marketing';
    protected $appVersionRequired = '9.0.0a1';
    protected $pkgVersion = '0.81';
    protected $pkgAutoloaderMapCoreExtensions = true;
    protected $pkgAutoloaderRegistries = array(
        'src' => '\PortlandLabs\ConcreteCmsMarketing'
    );

    public function getPackageDescription()
    {
        return t("The marketing.concretecms.com extensions.");
    }

    public function getPackageName()
    {
        return t("marketing.concretecms.com");
    }
    
    public function install()
    {
        parent::install();
        $this->installContentFile('data.xml');
        $this->installContentFile('content.xml');
    }

    public function upgrade()
    {
        parent::upgrade();
        $this->installContentFile('data.xml');
    }
    
    public function on_start()
    {
        
    }
}
