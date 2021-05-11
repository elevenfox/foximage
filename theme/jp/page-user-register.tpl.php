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

            <form class="user-info-from-cookie" enctype="multipart/form-data" action="/user" method="post" id="user-register-form" accept-charset="UTF-8">
                <div>
                    <div id="edit-account" class="form-wrapper">
                        <div class="form-item form-type-textfield form-item-name">
                            <label for="edit-name">Username <span class="form-required" title="This field is required.">*</span></label>
                            <input class="form-text" type="text" id="edit-name" name="name" value="<?=empty($_SESSION['register_form_user_name']) ? '' : $_SESSION['register_form_user_name']?>" size="60" maxlength="60" required="required" pattern="[A-Za-z0-9.\-_]{1,20}" title="Spaces and punctuation are not allowed except for periods, hyphens, and underscores.">
                            <div class="description">Spaces and punctuation are not allowed except for periods, hyphens, and underscores.</div>
                        </div>
                        <div class="form-item form-type-textfield form-item-mail">
                            <label for="edit-mail">E-mail address <span class="form-required" title="This field is required.">*</span></label>
                            <input type="email" id="edit-mail" name="mail" value="<?=empty($_SESSION['register_form_user_email']) ? '' : $_SESSION['register_form_user_email']?>" size="60" maxlength="254" class="form-text required" required="required">
                            <div class="description">A valid e-mail address. All e-mails from the system will be sent to this address. The e-mail address is not made public and will only be used if you wish to receive a new password or wish to receive certain news or notifications by e-mail.</div>
                        </div>
                        <div class="form-item form-type-password-confirm form-item-pass">
                            <div class="form-item form-type-password form-item-pass-pass1 password-parent">
                                <label for="edit-pass-pass1">Password <span class="form-required" title="This field is required.">*</span></label>
                                <input class="password-field form-text required" type="password" id="edit-pass-pass1" name="pass[pass1]" size="25" maxlength="128" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters">
                            </div>
                            <div class="form-item form-type-password form-item-pass-pass2 confirm-parent">
                                <label for="edit-pass-pass2">Confirm password <span class="form-required" title="This field is required.">*</span></label>
                                <input class="password-confirm form-text required" type="password" id="edit-pass-pass2" name="pass[pass2]" size="25" maxlength="128" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                            </div><div class="password-suggestions description" style="display: none;"></div>

                            <div class="description">Provide a password for the new account in both fields.</div>
                            <div class="description">Password must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters</div>
                        </div>
                        <input type="hidden" name="timezone" value="America/Los_Angeles">
                    </div>

                    <?php if( !empty( $_SESSION['register_error_msg'] )):?>
                        <div class="message-box error" style="color: red; margin: 20px 0"><?=$_SESSION['register_error_msg']?></div>
                        <?php unset($_SESSION['register_error_msg']); ?>
                    <?php endif;?>

                    <div class="form-actions form-wrapper" id="edit-actions">
                        <input type="submit" id="edit-submit" name="op" value="Create new account" class="form-submit btn btn-primary">
                        <input type="hidden" name="action" value="register">
                    </div>
                </div>
            </form>

            <script>
              var password = document.getElementById("edit-pass-pass1")
                , confirm_password = document.getElementById("edit-pass-pass2");

              function validatePassword(){
                if(password.value != confirm_password.value) {
                  confirm_password.setCustomValidity("Passwords Don't Match");
                } else {
                  confirm_password.setCustomValidity('');
                }
              }

              password.onchange = validatePassword;
              confirm_password.onkeyup = validatePassword;
            </script>

        </div>


    </div>

    <?=$theme->render(null, 'ads_templates/ad-side-right')?>


<?php include 'footer.tpl.php';?>