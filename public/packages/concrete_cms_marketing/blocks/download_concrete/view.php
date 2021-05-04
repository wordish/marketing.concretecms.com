<?php



defined('C5_EXECUTE') or die('Access denied');
if (isset($releaseData) && is_array($releaseData)) {
    $dateReleased = new DateTime($releaseData['dateReleased']);

?>

<section class="content-section column-section-container-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 content-section-column text-center">
                <h3><?=t('Version %s', $releaseData['version'])?></h3>
                <p><?=t('Released on %s', $dateReleased->format('F d, Y'))?></p>
                <div class="mt-5">
                    <a href="<?=$releaseData['releaseNotesUrl']?>" class="btn btn-secondary" target="_blank"><?=t('Release Notes')?></a>
                    <a href="<?=$releaseData['downloadUrl']?>" class="btn btn-primary"><?=t('Download')?></a>
                </div>
                <?php
                if ($releaseData['upgradeNotes']) { ?>
                    <p class="mt-5"><?=$releaseData['upgradeNotes']?></p>
                    <?php }
                ?>
                <?php
                if ($releaseData['md5sum']) { ?>
                    <p class="mt-5 text-muted"><?=t('MD5 Checksum: %s', $releaseData['md5sum'])?></p>
                <?php }
                ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>