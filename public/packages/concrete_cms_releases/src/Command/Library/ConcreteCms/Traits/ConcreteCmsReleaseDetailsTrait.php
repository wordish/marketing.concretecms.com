<?php

namespace PortlandLabs\Concrete\Releases\Command\Library\ConcreteCms\Traits;

trait ConcreteCmsReleaseDetailsTrait
{

    /**
     * @var string
     */
    protected $releaseDate;

    /**
     * @var string
     */
    protected $versionNumber;

    /**
     * @var string
     */
    protected $releaseNotes;

    /**
     * @var string
     */
    protected $md5sum;

    /**
     * @var string
     */
    protected $directDownloadFile;

    /**
     * @var string
     */
    protected $remoteUpdaterFile;

    /**
     * @var string
     */
    protected $releaseNotesUrl;

    /**
     * @var bool
     */
    protected $isAvailableForRemoteUpdate = false;

    /**
     * @var bool
     */
    protected $isPrerelease = false;

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return string
     */
    public function getVersionNumber(): string
    {
        return $this->versionNumber;
    }

    /**
     * @param string $versionNumber
     */
    public function setVersionNumber(string $versionNumber): void
    {
        $this->versionNumber = $versionNumber;
    }

    /**
     * @return string
     */
    public function getReleaseNotes(): string
    {
        return $this->releaseNotes;
    }

    /**
     * @param string $releaseNotes
     */
    public function setReleaseNotes(string $releaseNotes): void
    {
        $this->releaseNotes = $releaseNotes;
    }

    /**
     * @return string
     */
    public function getMd5sum(): string
    {
        return $this->md5sum;
    }

    /**
     * @param string $md5sum
     */
    public function setMd5sum(string $md5sum): void
    {
        $this->md5sum = $md5sum;
    }

    /**
     * @return string
     */
    public function getDirectDownloadFile(): string
    {
        return $this->directDownloadFile;
    }

    /**
     * @param string $directDownloadFile
     */
    public function setDirectDownloadFile(string $directDownloadFile): void
    {
        $this->directDownloadFile = $directDownloadFile;
    }

    /**
     * @return string
     */
    public function getRemoteUpdaterFile(): string
    {
        return $this->remoteUpdaterFile;
    }

    /**
     * @param string $remoteUpdaterFile
     */
    public function setRemoteUpdaterFile(string $remoteUpdaterFile): void
    {
        $this->remoteUpdaterFile = $remoteUpdaterFile;
    }

    /**
     * @return string
     */
    public function getReleaseNotesUrl(): string
    {
        return $this->releaseNotesUrl;
    }

    /**
     * @param string $releaseNotesUrl
     */
    public function setReleaseNotesUrl(string $releaseNotesUrl): void
    {
        $this->releaseNotesUrl = $releaseNotesUrl;
    }

    /**
     * @return bool
     */
    public function isAvailableForRemoteUpdate(): bool
    {
        return $this->isAvailableForRemoteUpdate;
    }

    /**
     * @param bool $isAvailableForRemoteUpdate
     */
    public function setIsAvailableForRemoteUpdate(bool $isAvailableForRemoteUpdate): void
    {
        $this->isAvailableForRemoteUpdate = $isAvailableForRemoteUpdate;
    }

    /**
     * @return bool
     */
    public function isPrerelease(): bool
    {
        return $this->isPrerelease;
    }

    /**
     * @param bool $isPrerelease
     */
    public function setIsPrerelease(bool $isPrerelease): void
    {
        $this->isPrerelease = $isPrerelease;
    }


}
