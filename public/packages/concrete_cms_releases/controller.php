<?php

namespace Concrete\Package\ConcreteCmsReleases;

use Concrete\Core\Database\Connection\Connection;
use Concrete\Core\Database\EntityManager\Provider\ProviderAggregateInterface;
use Concrete\Core\Database\EntityManager\Provider\ProviderInterface;
use Concrete\Core\Database\EntityManager\Provider\StandardPackageProvider;
use Concrete\Core\Package\Package;
use PortlandLabs\Concrete\Releases\ServiceProvider;

class Controller extends Package implements ProviderAggregateInterface
{

    protected $pkgHandle = 'concrete_cms_releases';
    protected $appVersionRequired = '9.2.0a1';
    protected $pkgVersion = '0.80';
    protected $pkgAutoloaderMapCoreExtensions = true;
    protected $pkgAutoloaderRegistries = array(
        'src' => '\PortlandLabs\Concrete\Releases'
    );

    public function getPackageDescription()
    {
        return t("A custom package for tracking releases of core Concrete CMS software libraries.");
    }

    public function getPackageName()
    {
        return t("Concrete Releases");
    }
    
    public function install()
    {
        parent::install();
        $this->installContentFile('data.xml');
        $this->on_start();
    }

    public function uninstall()
    {
        parent::uninstall();
        $db = $this->app->make(Connection::class);
        $db->executeUpdate('drop table if exists ConcreteReleases');
    }

    public function upgrade()
    {
        parent::upgrade();
        $this->installContentFile('data.xml');
    }
    
    public function on_start()
    {
        if (file_exists($this->getPackagePath() . "/vendor")) {
            require_once $this->getPackagePath() . "/vendor/autoload.php";
        }

        $provider = $this->app->make(ServiceProvider::class);
        $provider->register();
    }

    /**
     * @return ProviderInterface
     */
    public function getEntityManagerProvider()
    {
        return new StandardPackageProvider($this->app, $this, [
            'src/Entity' => "\PortlandLabs\Concrete\Releases\Entity"
        ]);
    }


}
