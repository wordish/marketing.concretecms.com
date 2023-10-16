<?php

defined('C5_EXECUTE') or die('Access denied');
use PortlandLabs\Concrete\Releases\Entity\ConcreteRelease;

if (isset($release) && $release instanceof ConcreteRelease) {
    $dateReleased = $release->getReleaseDate();

?>

<section class="content-section column-section-container-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 content-section-column text-center">
                <h3><?=t('Version %s', $release->getVersionNumber())?></h3>
                <p><?=t('Released on %s', $dateReleased->format('F d, Y'))?></p>
                <div class="mt-5">
                    <a href="<?=$release->getReleaseNotesUrl()?>" class="btn btn-secondary" target="_blank"><?=t('Release Notes')?></a>
                    <?php
                    if ($downloadFile = $release->getDirectDownloadFile()) { ?>
                        <a href="<?=$downloadFile->getDownloadURL()?>" class="btn btn-primary"><?=t('Download')?></a>
                    <?php } ?>
                </div>
                <?php
                if ($release->getMd5sum()) { ?>
                    <p class="mt-5 text-muted"><?=t('MD5 Checksum: %s', $release->getMd5sum())?></p>
                <?php }
                ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>