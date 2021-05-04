<?php

defined('C5_EXECUTE') or die('Access denied');

foreach($releases as $release) {
    $dateReleased = new DateTime($release['dateReleased']);
    ?>

    <div class="ccm-feature-item-button-right">

        <div class="ccm-feature-content">
            <h2 class="ccm-feature-title">
                <?=$release['version']?>
            </h2>

            <div class="ccm-feature-description">
                <?=t('Released on %s', $dateReleased->format('F d, Y'))?>
            </div>
        </div>

        <div class="ml-auto d-flex">
        <?php
        if ($release['releaseNotesUrl']) { ?>
            <a href="<?=$release['releaseNotesUrl']?>" class="mr-2 ccm-feature-link btn btn-secondary" target="_blank">
                <?=t('Release Notes')?>
            </a>

        <?php }
        ?>
        <a href="<?=$release['downloadUrl']?>" class="ccm-feature-link btn btn-primary">
            <?=t('Download')?>
        </a>
        </div>
    </div>
<?php } ?>