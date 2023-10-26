<?php

defined('C5_EXECUTE') or die('Access denied');

foreach($releases as $release) {
    /**
     * @var $release \PortlandLabs\Concrete\Releases\Entity\ConcreteRelease
     */
    ?>

    <div class="ccm-feature-item-button-right">

        <div class="ccm-feature-content">
            <h2 class="ccm-feature-title">
                <?=$release->getVersionNumber()?>
            </h2>

            <div class="ccm-feature-description">
                <?=t('Released on %s', $release->getReleaseDate()->format('F d, Y'))?>
            </div>
        </div>

        <div class="ms-auto d-flex">
        <?php
        if ($release->getReleaseNotesUrl()) { ?>
            <a href="<?=$release->getReleaseNotesUrl()?>" class="me-2 ccm-feature-link btn btn-secondary" target="_blank">
                <?=t('Release Notes')?>
            </a>

        <?php }
        if ($release->getDirectDownloadFile()) { ?>
            <a href="<?=$release->getDirectDownloadFile()->getDownloadURL()?>" class="ccm-feature-link btn btn-primary">
                <?=t('Download')?>
            </a>
        <?php } ?>
        </div>
    </div>
<?php } ?>