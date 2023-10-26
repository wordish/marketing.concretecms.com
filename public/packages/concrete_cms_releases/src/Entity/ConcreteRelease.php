<?php

namespace PortlandLabs\Concrete\Releases\Entity;

use Michelf\Markdown;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="ConcreteReleaseRepository")
 * @ORM\Table(name="ConcreteReleases")
 */
class ConcreteRelease implements \JsonSerializable
{

    /**
     * @ORM\Id @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\Column(type="date", options={"unsigned": true})
     */
    protected $releaseDate;

    /**
     * @ORM\Column(type="string")
     */
    protected $versionNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $versionName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $releaseNotes;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $md5sum;

    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Core\Entity\File\File")
     * @ORM\JoinColumn(name="directDownloadFile", referencedColumnName="fID", onDelete="SET NULL")
     */
    protected $directDownloadFile;

    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Core\Entity\File\File")
     * @ORM\JoinColumn(name="remoteUpdaterFile", referencedColumnName="fID", onDelete="SET NULL")
     */
    protected $remoteUpdaterFile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $releaseNotesUrl;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isAvailableForRemoteUpdate = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isPrerelease = false;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate(string $format = null)
    {
        if ($format && !empty($this->releaseDate)) {
            return $this->releaseDate->format($format);
        } else {
            return $this->releaseDate;
        }
    }

    /**
     * @param mixed $releaseDate
     */
    public function setReleaseDate($releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return mixed
     */
    public function getVersionNumber()
    {
        return $this->versionNumber;
    }

    /**
     * @param mixed $versionNumber
     */
    public function setVersionNumber($versionNumber): void
    {
        $this->versionNumber = $versionNumber;
    }

    /**
     * @return mixed
     */
    public function getVersionName()
    {
        return $this->versionName;
    }

    /**
     * @param mixed $versionName
     */
    public function setVersionName($versionName): void
    {
        $this->versionName = $versionName;
    }

    /**
     * @return mixed
     */
    public function getReleaseNotes()
    {
        return $this->releaseNotes;
    }

    /**
     * @return string
     */
    public function getFormattedReleaseNotes(): string
    {
        return Markdown::defaultTransform(h($this->getReleaseNotes()));
    }

    /**
     * @param mixed $releaseNotes
     */
    public function setReleaseNotes($releaseNotes): void
    {
        $this->releaseNotes = $releaseNotes;
    }

    /**
     * @return mixed
     */
    public function getDirectDownloadFile()
    {
        return $this->directDownloadFile;
    }

    /**
     * @param mixed $directDownloadFile
     */
    public function setDirectDownloadFile($directDownloadFile): void
    {
        $this->directDownloadFile = $directDownloadFile;
    }

    /**
     * @return mixed
     */
    public function getRemoteUpdaterFile()
    {
        return $this->remoteUpdaterFile;
    }

    /**
     * @param mixed $remoteUpdaterFile
     */
    public function setRemoteUpdaterFile($remoteUpdaterFile): void
    {
        $this->remoteUpdaterFile = $remoteUpdaterFile;
    }

    /**
     * @return mixed
     */
    public function getReleaseNotesUrl()
    {
        return $this->releaseNotesUrl;
    }

    /**
     * @param mixed $releaseNotesUrl
     */
    public function setReleaseNotesUrl($releaseNotesUrl): void
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
     * @return mixed
     */
    public function getMd5sum()
    {
        return $this->md5sum;
    }

    /**
     * @param mixed $md5sum
     */
    public function setMd5sum($md5sum): void
    {
        $this->md5sum = $md5sum;
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

    public function jsonSerialize()
    {
        $releaseDate = null;
        $directDownloadFileId = null;
        $remoteUpdaterFileId = null;
        if ($directDownloadFile = $this->getDirectDownloadFile()) {
            $directDownloadFileId = $directDownloadFile->getFileID();
        }
        if ($remoteUpdaterFile = $this->getRemoteUpdaterFile()) {
            $remoteUpdaterFileId = $remoteUpdaterFile->getFileID();
        }
        if ($this->getReleaseDate()) {
            $releaseDate = $this->getReleaseDate()->format('Y-m-d');
        }
        return [
            'id' => $this->getId(),
            'releaseDate' => $releaseDate,
            'versionNumber' => $this->getVersionNumber(),
            'versionName' => $this->getVersionName(),
            'md5sum' => $this->getMd5sum(),
            'releaseNotes' => $this->getReleaseNotes(),
            'releaseNotesUrl' => $this->getReleaseNotesUrl(),
            'directDownloadFile' => $directDownloadFileId,
            'remoteUpdaterFile' => $remoteUpdaterFileId,
            'isPrerelease' => $this->isPrerelease(),
            'isAvailableForRemoteUpdate' => $this->isAvailableForRemoteUpdate(),
        ];
    }


}
