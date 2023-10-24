<?php

defined('C5_EXECUTE') or die('Access denied');

?>

<h4><?= t('Documentation User') ?></h4>
<p><?= t(
        'Login as a user who can post changelogs for every release. This user must be able to add developer document page types to the Version History section of the documentation website.'
    ) ?></p>
<?php

if (isset($resourceOwner) && is_array($resourceOwner)) { ?>

    <div class="card mb-3">
        <div class="card-body hstack gap-3 align-items-center">
            <img src="<?=$resourceOwner['avatar']?>" style="max-height: 60px" class="img-fluid rounded-start">
            <div>
                <div><b><?=$resourceOwner['username']?></b></div>
                <div><a href="mailto:<?=$resourceOwner['email']?>"><?=$resourceOwner['email']?></a></div>
            </div>
        </div>
    </div>

    <form method="post" action="<?=$view->action('reset')?>">
        <?=$token->output('reset')?>
        <button type="submit" class="btn btn-primary"><?=t('Reset')?></button>
    </form>


<?php
} else { ?>

    <div class="alert alert-warning"><?= t(
            'Unable to retrieve an account connected to the Documentation API. Please authorize an account to post to the documentation website using the button below.'
        ) ?></div>

    <a href="<?= $view->action('authorize') ?>" class="btn btn-primary"><?=t('Authorize')?></a>

    <?php
} ?>

