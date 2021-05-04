<?php

namespace Concrete\Package\ConcreteCmsMarketing\Block\DownloadConcrete;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Http\Client\Client;

class Controller extends BlockController
{
    protected $btTable = "btDownloadConcrete";
    protected $btIgnorePageThemeGridFrameworkContainer = true;

    public function getBlockTypeDescription()
    {
        return t('Links to a Concrete release for download.');
    }

    public function getBlockTypeName()
    {
        return t('Download Concrete');
    }

    protected function loadReleases()
    {
        $client = $this->app->make(Client::class);
        $response = $client->get($_ENV['CONCRETE_API_URL'] . '/concrete_releases?order[dateReleased]=desc');
        $data = json_decode((string) $response->getBody(), true);
        $releases = ['' => t('** Select a Version')];
        foreach($data['hydra:member'] as $release) {
            $releases[$release['id']] = $release['version'];
        }
        $this->set('releases', $releases);
    }

    public function add()
    {
        $this->loadReleases();
    }

    public function view()
    {
        try {
            $this->set('releaseData', json_decode($this->releaseObject, true));
        } catch (\Exception $e) {
            $this->set('releaseData', []);
        }
    }

    public function save($args)
    {
        $releaseID = $args['releaseID'];
        if ($releaseID) {
            $client = $this->app->make(Client::class);
            $response = $client->get($_ENV['CONCRETE_API_URL'] . '/concrete_releases/' . $releaseID);
            $data = json_decode((string)$response->getBody(), true);
            if (isset($data['id'])) {
                $args['releaseObject'] = json_encode($data);
                return parent::save($args);
            }
        }
        throw new \Exception(t('You must specify a valid release ID.'));
    }

    public function edit()
    {
        $this->loadReleases();
    }
}
