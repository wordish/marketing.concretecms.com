<?php

/**
 * @project:   ConcreteCMS Theme
 *
 * @copyright  (C) 2021 Portland Labs (https://www.portlandlabs.com)
 * @author     Fabian Bitter (fabian@bitter.de)
 */

defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Core\Form\Service\Form;
use Concrete\Core\Support\Facade\Application;
use Concrete\Core\Support\Facade\Url;
use Concrete\Core\User\User;
use Concrete\Core\Validation\CSRF\Token;

$app = Application::getFacadeApplication();
/** @var Form $form */
$form = $app->make(Form::class);
/** @var Token $token */
$token = $app->make(Token::class);

$user = new User();

?>

<div class="get-started">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="inner-content">
                    <h3 class="highlight ">
                        <?php echo t("We're going to provision a new intranet for you."); ?>
                    </h3>

                    <p class="lead">
                        <strong>
                            <?php echo t("Enter the project name so you can find it in your My Profile area later."); ?>
                        </strong>
                    </p>

                    <form action="<?php echo (string)Url::to("/get-started/choose/submit"); ?>" method="post">
                        <?php echo $token->output("create_project"); ?>

                        <?php
                        // @todo: add hidden fields here to pass the required query parameters
                        ?>

                        <?php echo $form->text("projectName"); ?>

                        <p class="change-user">
                            <?php if ($user->isRegistered()) { ?>
                                <?php echo t("You're logged in as <strong>%s</strong>", $user->getUserName()); ?>

                                <br>

                                <a href="<?php echo (string)Url::to("/get-started/choose/change_user"); ?>"
                                   class="ccm-login-popup">
                                    <?php echo t("Login as someone else"); ?>
                                </a>
                            <?php } else { ?>
                                <?php echo t("You're not logged in"); ?>

                                <br>

                                <a href="<?php echo (string)Url::to("/login"); ?>">
                                    <?php echo t("Login now"); ?>
                                </a>
                            <?php } ?>
                        </p>

                        <div class="actions">
                            <a href="<?php echo (string)Url::to("/get-started/try"); ?>" class="btn btn-secondary">
                                <?php echo t("Cancel"); ?>
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <?php echo t("Create Site"); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>