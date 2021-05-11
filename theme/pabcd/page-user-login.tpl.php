<?php
/* @var Array $data */
/* @var Theme $theme */

if(!empty($_SESSION['user'])) {
    goToUrl('/user');
}

include 'header.tpl.php';

?>


    <div class="content-container page-user-login">

        <h1><?php print $data['page_title']; ?></h1>

        <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

        <div id="content" class="content">

            <form action="/user" method="post" id="user-login" accept-charset="UTF-8">
                <div>
                    <div class="form-item form-type-textfield form-item-name">
                        <label for="edit-name">
                            Username
                            <span class="form-required" title="This field is required.">*</span>
                        </label>
                        <input type="text" id="edit-name" name="name" value="<?=empty($_SESSION['login_form_user_name']) ? '' : $_SESSION['login_form_user_name']?>" size="60" maxlength="60" class="form-text required" required="required">
                        <div class="description">Enter your Porn Asian Japanese AV Sex Video username.</div>
                    </div>
                    <div class="form-item form-type-password form-item-pass">
                        <label for="edit-pass">Password <span class="form-required" title="This field is required.">*</span></label>
                        <input type="password" id="edit-pass" name="pass" size="60" maxlength="128" class="form-text required" required="required">
                        <div class="description">Enter the password that accompanies your username.</div>
                    </div>

                    <?php if( !empty( $_SESSION['login_error_msg'] )):?>
                        <div class="message-box error" style="color: red; margin: 20px 0"><?=$_SESSION['login_error_msg']?></div>
                        <?php unset($_SESSION['login_error_msg']); ?>
                    <?php endif;?>
                    <div class="form-actions form-wrapper" id="edit-actions">
                        <input type="submit" id="edit-submit" name="op" value="Log in" class="form-submit btn btn-primary">
                        <input type="hidden" name="action" value="login">
                    </div>
                </div>
            </form>

        </div>


    </div>

    <?=$theme->render(null, 'ads_templates/ad-side-right')?>


<?php include 'footer.tpl.php';?>