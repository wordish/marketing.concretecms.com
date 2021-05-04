<?php

namespace Concrete\Package\ConcreteCmsMarketing\Block\ConcreteReleaseList;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Http\Client\Client;

class Controller extends BlockController
{
    public function getBlockTypeDescription()
    {
        return t('Shows a list of all Concrete version releases.');
    }

    public function getBlockTypeName()
    {
        return t('Concrete Release List');
    }

    public function view()
    {
        $client = $this->app->make(Client::class);
        $response = $client->get($_ENV['CONCRETE_API_URL'] . '/concrete_releases?order[dateReleased]=desc');
        $data = json_decode((string) $response->getBody(), true);
        $releases = [];
        foreach($data['hydra:member'] as $release) {
            if ($release['isPublished']) {
                $releases[] = $release;
            }
        }
        $this->set('releases', $releases);
    }

}
