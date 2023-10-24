<?php

namespace PortlandLabs\Concrete\Releases\Api\Transformer;

use League\Fractal\TransformerAbstract;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;
use PortlandLabs\Concrete\Releases\RemoteUpdate\RemoteUpdate;

/**
 * A release transformer that formats the release in a way that the remote updater expects
 * to see it.
 */
class ConcreteRemoteUpdateTransformer extends TransformerAbstract
{
    public function transform(RemoteUpdate $update)
    {
        $downloadUrl = $update->getRemoteUpdaterFile()?->getDownloadURL() ?? null;
        return [
            'version' => $update->getVersionNumber(),
            'notes' => $update->getAllFormattedReleaseNotes(),
            'notes_url' => $update->getReleaseNotesUrl(),
            'identifier' => $update->getVersionNumber(),
            'date' => $update->getReleaseDate('Y-m-d'),
            'direct_download_url' => (string) $downloadUrl,
        ];
    }

}