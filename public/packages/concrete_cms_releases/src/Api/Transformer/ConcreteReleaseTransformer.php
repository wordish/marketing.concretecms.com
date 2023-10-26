<?php

namespace PortlandLabs\Concrete\Releases\Api\Transformer;

use Concrete\Core\Api\Fractal\Transformer\FileTransformer;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

class ConcreteReleaseTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'remote_updater_file',
        'direct_download_file',
    ];

    protected $defaultIncludes = [
        'remote_updater_file',
        'direct_download_file',
    ];

    public function transform(ConcreteRelease $release)
    {
        return [
            'id' => $release->getId(),
            'version_number' => $release->getVersionNumber(),
            'version_name' => $release->getVersionName(),
            'release_notes' => $release->getReleaseNotes(),
            'release_notes_url' => $release->getReleaseNotesUrl(),
            'release_date' => $release->getReleaseDate('Y-m-d'),
            'md5_sum' => $release->getMd5sum(),
            'is_available_for_remote_update' => $release->isAvailableForRemoteUpdate(),
            'is_pre_release' => $release->isPrerelease(),
        ];
    }

    public function includeRemoteUpdaterFile(ConcreteRelease $release)
    {
        $file = $release->getRemoteUpdaterFile();
        if ($file) {
            return new Item($file, new FileTransformer());
        }
    }

    public function includeDirectDownloadFile(ConcreteRelease $release)
    {
        $file = $release->getDirectDownloadFile();
        if ($file) {
            return new Item($file, new FileTransformer());
        }
    }

}