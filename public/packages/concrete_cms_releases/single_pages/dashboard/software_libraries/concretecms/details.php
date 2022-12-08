<?php

defined('C5_EXECUTE') or die('Access denied');

/**
 * @var $release \PortlandLabs\Concrete\Releases\Entity\ConcreteRelease
 */
?>

<div class="ccm-dashboard-header-buttons">
    <div class="btn-group">
        <a href="<?= $backURL ?>" class="btn btn-secondary"><?= t("Back") ?></a>
        <?php
        if (isset($editURL) && $editURL) { ?>
            <a href="<?= $editURL ?>" class="btn btn-secondary"><?= t("Edit") ?></a>
            <?php
        } ?>
        <?php
        if ($allowDelete) { ?>
            <button type="button" class="btn btn-danger" data-modal-options='{"title": "<?=t('Delete Release')?>"}' data-launch-modal="delete-release"><?= t('Delete') ?></button>
            <?php
        } ?>
    </div>
</div>

<?php
if ($allowDelete) { ?>
    <div class="d-none">
        <div data-modal-content="delete-release">
            <form method="post" action="<?= $view->action('delete', $release->getID()) ?>">
                <?= Core::make("token")->output('delete') ?>
                <input type="hidden" name="id" value="<?= $release->getID() ?>">
                <p><?= t(
                        'Are you sure you want to delete this Concrete CMS release?'
                    ) ?></p>
                <div class="dialog-buttons">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        <?php echo t('Cancel') ?>
                    </button>
                    <button class="btn btn-danger ms-auto"
                            onclick="$('[data-modal-content=delete-release] form').submit()"><?= t(
                            'Delete Release'
                        ) ?></button>
                </div>
            </form>
        </div>
    </div>
    <?php
} ?>

<div>

    <section class="pb-3 mb-3 border-bottom border-secondary-50">
        <h3><?=$release->getVersionNumber()?></h3>

        <div class="text-secondary"><?=t('Released on %s', $release->getReleaseDate('F d, Y'))?></div>
    </section>

    <section class="pb-3 mb-3 border-bottom border-secondary-50">
        <div class="mb-3">
            <b><?=t('MD5 Sum')?></b>
            <div><?=$release->getMd5sum()?></div>
        </div>

        <div class="mb-3">
            <b><?=t('Release Notes URL')?></b>
            <div><a href="<?=$release->getReleaseNotesUrl()?>" target="_blank"><?=$release->getReleaseNotesUrl()?></a></div>
        </div>

        <div class="mb-3">
            <b><?=t('File')?></b>

            <?php
            $file = $release->getDirectDownloadFile();
            if ($file) { ?>
                <div><a href="<?=$file->getDetailsURL()?>" target="_blank"><?=$file->getFilename()?></a></div>
            <?php } else { ?>
                <div class="text-secondary"><?=t('None')?></div>
            <?php } ?>
        </div>

        <div>
            <b><?=t('Is Pre-release?')?></b>
            <div>
                <?=$release->isPrerelease() ? t('Yes') : t('No')?>
            </div>
        </div>

    </section>

    <section class="pb-3 mb-3 border-bottom border-secondary-50">
        <div class="mb-3">
            <b><?=t('Available for Remote Update?')?></b>
            <div>
                <?=$release->isAvailableForRemoteUpdate() ? t('Yes') : t('No')?>
            </div>
        </div>

        <div>
            <b><?=t('Remote Update File')?></b>

            <?php
            $file = $release->getRemoteUpdaterFile();
            if ($file) { ?>
                <div><a href="<?=$file->getDetailsURL()?>" target="_blank"><?=$file->getFilename()?></a></div>
            <?php } else { ?>
                <div class="text-secondary"><?=t('None')?></div>
            <?php } ?>
        </div>

    </section>

    <?=$release->getFormattedReleaseNotes()?>

</div>
