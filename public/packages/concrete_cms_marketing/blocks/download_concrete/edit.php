<?php

defined('C5_EXECUTE') or die('Access denied');


?>

<div class="form-group">

    <?php echo $form->label("releaseID", t('Release')); ?>
    <?php echo $form->select("releaseID", $releases); ?>

</div>