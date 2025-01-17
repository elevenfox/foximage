<?php
/* @var Array $data */
/* @var Theme $theme */

include 'header.tpl.php';

//ZDebug::my_print($data);
$user = $data['user'];
?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<style>body{background-color: #ccc;}</style>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <div class="content-container page-user-dashboard">

        <h1><?php print $data['page_title']; ?></h1>

        <?= $theme->render(null, 'ads_templates/ad-m-middle');?>

        <div id="content" class="content">
            <div class="dashboard-section account">
                <h4 class="ds-title">Account</h4>
                <div class="ds-main">
                    <div class="ds-row account-name">
                        <span><?=$user['name']?></span>
                    </div>
                    <div class="ds-row account-mail">
                        <span><?=$user['mail']?></span>
                        <a id="edit-email" class="right" href="#" data-toggle="modal" data-target="#edit-email-modal">Edit email</a>
                    </div>
                    <div class="ds-row account-pass">
                        <span>Password: ********</span>
                        <a id="change-password" class="right" href="#" data-toggle="modal" data-target="#change-password-modal">Change password</a>
                    </div>
                </div>
            </div>

            <div class="dashboard-section my-File">
                <h4 class="ds-title">My Files</h4>
                <div class="ds-main">
                    <div style="width: 100%"><a id="upload-File" class="right upload-File" href="#" data-toggle="modal" data-target="#upload-File-modal">Upload File</a></div>
                    <div class="ds-File-intro">Below is the list of all Files you have uploaded</div>

                    <?php if(empty($user['Files'])) : ?>
                        <div class="clearfix" style="line-height: 50px; font-style: italic;"> - &nbsp;&nbsp; You have not uploaded any File yet.</div>
                    <?php else: ?>
                    <ul>
                        <?php foreach ($user['Files'] as $File) : ?>
                            <li class="ds-row">
                                <a class="ds-row-left" href="/File/<?=cleanStringForUrl($File['title'])?>/<?=$File['source_url_md5']?>"><?=$File['title']?></a>
                                <div class="right delete-icon" style="display: inline-block">
                                    <a class="delete-File" data_id="<?=$File['source_url_md5']?>" data_title="<?=$File['title']?>" href="#" data-toggle="modal" data-target="#delete-File-modal">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach;?>
                    </ul>
                    <?php endif;?>
                </div>
            </div>

        </div>


    </div>

    <?=$theme->render(null, 'ads_templates/ad-side-right')?>

    <!-- Modal -->
    <div id="edit-email-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Email</h4>
                </div>
                <div class="modal-body">
                    <label for="edit-mail">E-mail address</label>
                    <input type="email" id="edit-mail" name="mail" value="<?=empty($user['mail']) ? '' : $user['mail']?>" maxlength="254" class="form-text required" required="required" style="width: 100%">
                    <div class="description" style="font-size: 85%; padding: 3px;">A valid e-mail address. All e-mails from the system will be sent to this address. The e-mail address is not made public and will only be used if you wish to receive a new password or wish to receive certain news or notifications by e-mail.</div>
                </div>
                <div class="alert alert-danger" role="alert" style="display: none"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div id="change-password-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-item form-type-password-confirm form-item-pass">
                        <div class="form-item form-type-password form-item-pass-pass1 password-parent">
                            <label for="edit-pass-pass1">Current Password </label>
                            <input class="password-field form-text required" type="password" id="edit-pass-pass0" name="pass[pass0]" maxlength="128" required="required" style="width: 100%">
                        </div>
                        <div>&nbsp;</div>
                        <div class="form-item form-type-password form-item-pass-pass1 password-parent">
                            <label for="edit-pass-pass1">New Password </label>
                            <input class="password-field form-text required" type="password" id="edit-pass-pass1" name="pass[pass1]" maxlength="128" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" style="width: 100%">
                        </div>
                        <div class="form-item form-type-password form-item-pass-pass2 confirm-parent">
                            <label for="edit-pass-pass2">Confirm New Password </label>
                            <input class="password-confirm form-text required" type="password" id="edit-pass-pass2" name="pass[pass2]" maxlength="128" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" style="width: 100%">
                            <div class="description" style="font-size: 85%; padding: 3px;">Password must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters</div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger" role="alert" style="display: none"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Change</button>
                </div>
                <script>
                  var password = document.getElementById("edit-pass-pass1")
                    , confirm_password = document.getElementById("edit-pass-pass2");

                  function validatePassword(){
                    if(password.value !== confirm_password.value) {
                      confirm_password.setCustomValidity("Passwords Don't Match");
                      confirm_password.reportValidity();
                    } else {
                      confirm_password.setCustomValidity('');
                    }
                  }

                  password.onchange = validatePassword;
                  confirm_password.onkeyup = validatePassword;
                </script>
            </div>
        </div>
    </div>

    <div id="upload-File-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Upload a File</h4>
                </div>
                <div class="modal-body">
                    <label for="edit-mail">File URL</label>
                    <input type="text" id="File-url" name="File-url" value="" class="form-text required" required="required" style="width: 100%">
                    <div class="description" style="font-size: 85%; padding: 3px;">Copy a File url from other website, we'll processing it and save it.</div>
                </div>
                <div class="alert alert-danger" role="alert" style="display: none"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </div>
    </div>

    <div id="delete-File-modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Are you sure for deleting?</h4>
                </div>
                <div class="modal-body">
                    <div id="File-title" style="font-style: italic"></div>
                </div>
                <input type="hidden" name="File_md5_id" value="">
                <div class="alert alert-danger" role="alert" style="display: none"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
      (function($) {
        // When click the trash icon, need to display specific File title
        $('.delete-File').on('click', function(){
          var FileTitle = $(this).attr('data_title');
          var FileId = $(this).attr('data_id');
          $('#delete-File-modal #File-title').text(FileTitle);
          $('#delete-File-modal input[name="File_md5_id"]').val(FileId);
        });


        // Handle ok-button in edit-email Modal
        $('#edit-email-modal .btn-primary').on('click', function(){
            $('.loading').show();
            var emailObj = $('#edit-email-modal input[name="mail"]');
            if(!emailObj[0].checkValidity()) {
              emailObj[0].reportValidity();
              return;
            }
            var email = emailObj.val();
            var data = {
              'ac' : 'save_user_email',
              'email': email,
            };
            $.post('/api/', data, function (res) {
                if(res) {
                  alert('Success');
                  location.reload();
                }
                else {
                  $('.loading').hide();
                  $('#edit-email-modal .alert-danger').show().text('Failed to save email!');
                }
            });
        });

        // Handle ok-button in change-password Modal
        $('#change-password-modal .btn-primary').on('click', function(){
          $('.loading').show();
          var pass0 = $('#change-password-modal input[name="pass[pass0]"]');
          var pass1 = $('#change-password-modal input[name="pass[pass1]"]');
          var pass2 = $('#change-password-modal input[name="pass[pass2]"]');

          if(!pass0[0].checkValidity()) {
            pass0[0].reportValidity();
            return;
          }
          if(!pass1[0].checkValidity()) {
            pass1[0].reportValidity();
            return;
          }

          var currentPass = pass0.val();
          var newpass = pass1.val();
          var newpassConfirm = pass2.val();
          if(newpass !== newpassConfirm) {
            $('.loading').hide();
            $('#change-password-modal .alert-danger').show().text('Password not match!');
            return;
          }

          var data = {
            'ac' : 'save_user_password',
            'currentPass': currentPass,
            'newPass': newpass,
          };
          $.post('/api/', data, function (res) {
            if(res) {
              alert('Success');
              location.reload();
            }
            else {
              $('.loading').hide();
              $('#change-password-modal .alert-danger').show().text('Failed to change password!');
            }
          });
        });

        // Handle ok-button in upload-File Modal
        $('#upload-File-modal .btn-primary').on('click', function(){
          $('.loading').show();
          var FileUrlObj = $('#upload-File-modal input[name="File-url"]');
          if(!FileUrlObj[0].checkValidity()) {
            FileUrlObj[0].reportValidity();
            return;
          }
          var FileUrl = FileUrlObj.val();
          var data = {
            'ac' : 'upload_File_by_user',
            'FileUrl': FileUrl,
          };
          $.post('/api/', data, function (res) {
            if(res) {
              alert('Success');
              location.reload();
            }
            else {
              $('.loading').hide();
              $('#upload-File-modal .alert-danger').show().text('Failed to upload File!');
            }
          });
        });

        // Handle ok-button in delete-File Modal
        $('#delete-File-modal .btn-primary').on('click', function(){
          $('.loading').show();
          var File_md5_id = $('#delete-File-modal input[name="File_md5_id"]').val();
          var data = {
            'ac' : 'delete_File_by_user',
            'File_md5_id': File_md5_id,
          };
          $.post('/api/', data, function (res) {
            if(res) {
              alert('Success');
              location.reload();
            }
            else {
              $('.loading').hide();
              $('#delete-File-modal .alert-danger').show().text('Failed to delete File!');
            }
          });
        });



      })(jQuery);
    </script>

<?php include 'footer.tpl.php';?>