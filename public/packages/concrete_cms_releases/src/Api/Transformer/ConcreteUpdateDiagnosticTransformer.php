<?php

namespace PortlandLabs\Concrete\Releases\Api\Transformer;

use League\Fractal\TransformerAbstract;
use PortlandLabs\Concrete\Releases\RemoteUpdate\Diagnostic;

class ConcreteUpdateDiagnosticTransformer extends TransformerAbstract
{

    public function getDefaultIncludes()
    {
        return ['current_version', 'requested_version'];
    }

    public function transform(Diagnostic $diagnostic)
    {
        // @TODO - Bring back status and safety and check marketplace status in realtime.
        return [
            'current_version' => $this->item($diagnostic->currentVersion, new ConcreteRemoteUpdateTransformer()),
            'requested_version' => $this->item($diagnostic->requestedVersion, new ConcreteRemoteUpdateTransformer()),
            'marketplace_item_status' => null,
            'notices' => [],
            'status' => [
                'safety' => 1,
                'status' => '',
            ]
        ];
    }

    public function includeCurrentVersion(Diagnostic $diagnostic)
    {
        return $this->item($diagnostic->currentVersion, new ConcreteRemoteUpdateTransformer());
    }

    public function includeRequestedVersion(Diagnostic $diagnostic)
    {
        return $this->item($diagnostic->requestedVersion, new ConcreteRemoteUpdateTransformer());
    }


}