<?php

namespace PortlandLabs\Concrete\Releases\Api\Model;

/**
 * Used to deliver version information to versions of concrete expecting to receive it in the old marketplace.concretecms.com format.
 * @OA\Schema(title="ConcreteLegacyRelease model")
 */
class ConcreteLegacyRelease
{

    /**
     * @OA\Property(type="string", title="UUID")

     * @var string
     */
    private $id;

    /**
     * @OA\Property(type="string", title="Release date")
     */
    private $releaseDate;

    /**
     * @OA\Property(type="string", title="Version number")
     */
    private $versionNumber;

    /**
     * @OA\Property(type="string", title="Version number")
     */
    private $versionName;

    /**
     * @OA\Property(type="string", title="Release Notes")
     */
    private $releaseNotes;

    /**
     * @OA\Property(type="string", title="Release Notes URL")
     */
    private $releaseNotesUrl;

    /**
     * @OA\Property(type="integer", title="Direct download File ID")
     */
    private $directDownloadFile;

    /**
     * @OA\Property(type="integer", title="Remote Updater download File ID")
     */
    private $remoteUpdaterFile;

    /**
     * @OA\Property(type="string", title="MD5 sum")
     */
    private $md5sum;

    /**
     * @OA\Property(type="boolean", title="is prerelease")

     * @var string
     */
    private $isPrelease;

    /**
     * @OA\Property(type="boolean", title="is available for remote update")

     * @var string
     */
    private $isAvailableForRemoteUpdate;


}