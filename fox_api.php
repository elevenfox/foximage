<?php
require_once './bootstrap.inc';

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

import('dao.File');

$pre = Config::get('db_table_prefix');

$action = empty($_REQUEST['ac']) ? 'default' : $_REQUEST['ac'];

switch($action) {
    case 'get_max_File_id':
        echo File::getMaxFileId();
        break;

    case 'File_exist':
        $url = $_GET['url'];
        $res = File::getFileBySourceUrl($url);
        echo empty($res) ? null : $res['id'];
        break;

    // case 'get_file_by_key':
    //     $key = $_GET['key'];
    //     $result = File::getFileByMd5($key);
    //     $File = empty($result) ? null : $result;
    //     echo json_encode($File);
    //     break;

    case 'import_file':
        $the_url = $_GET['url'];
        $target_url = urldecode($the_url);

        echo $target_url;

        break;

    case 'save_File_data':
    case 'save_File_data_and_node':
        $FileObj = json_decode($_POST['obj']);
        if(empty($FileObj)) {
            $post = json_decode(file_get_contents("php://input"));
            $FileObj = $post->obj;
        }

        if($FileObj->duration < 90) {
            error_log("Do not save File which has duration less than 90 seconds.");
            echo 0;
            return false;
        }

        // Save all info to Files table
        $res = File::save($FileObj);

        echo $res ? 1 : 0;
        break;

    case 'save_user_email':
        $res = false;

        $mail = $_POST['email'];
        // Make sure can only change current user own email
        if(!empty($_SESSION['user'])) {
            $res = User::saveUser($_SESSION['user']['uid'], $_SESSION['user']['name'], $mail);
        }

        apiReturnJson($res);
        break;

    case 'save_user_password':
        $res = false;

        $currentPass = $_POST['currentPass'];
        $newPass = $_POST['newPass'];
        // Make sure can only change current user own password
        if(!empty($_SESSION['user'])) {
            $result = User::authencate($_SESSION['user']['name'], $currentPass);
            if($result) {
                $res = User::saveUser($_SESSION['user']['uid'], $_SESSION['user']['name'], $_SESSION['user']['mail'], $newPass);
            }
        }

        apiReturnJson($res);
        break;

    case 'upload_File_by_user':
        $res = false;

        $FileUrl = $_POST['FileUrl'];

        // Make sure can only delete File owned by current user
        if(!empty($_SESSION['user'])) {
            $data = ['url' => $FileUrl];
            $api_server = Config::get('api_server');
            $imv_url = $api_server . '/parse_File_by_url/';
            try {
                $result = json_decode(curl_call($imv_url, 'post', $data));
                $parseStatus = $result->status;
                if ($parseStatus) {
                    $vObj = $result->result;
                    $res = File::save($vObj, $_SESSION['user']['name']);
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
                $res = $e->getMessage();
            }
        }
        apiReturnJson($res);
        break;

    case 'delete_File_by_user':
        $res = false;

        $File_md5_id = $_POST['File_md5_id'];
        // Make sure can only delete File owned by current user
        if(!empty($_SESSION['user'])) {
            $File = File::getFileByMd5($File_md5_id);
            if(!empty($File) && ($File['user_name'] == $_SESSION['user']['name'] || isAdmin()) ) {
                $res = File::deleteByMd5($File_md5_id);
            }
        }

        apiReturnJson($res);
        break;

    case 'delete_File_by_admin_opln35lmz9517sdjf':
        $res = false;

        $File_md5_id = $_POST['File_md5_id'];
        $token = $_POST['d_token'];
        if( !empty($token) && $token == Config::get('db_driver') ) {
            $res = File::deleteByMd5($File_md5_id);
        }

        apiReturnJson($res);
        break;

    case 'mark_File_for_deleting_kgdfur35fjgf9517lsdmh':
        $res = false;

        $source_url = $_POST['source_url'];
        $token = $_POST['d_token'];

        //If post-data is empty, try to takes raw data from the request
        if(empty($source_url)) {
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            $source_url = $data->source_url;
            $token = $data->d_token;
        }

        if( !empty($token) && $token == Config::get('db_driver') ) {
            $res = File::markForDeleting($source_url);
        }

        apiReturnJson($res);
        break;

    case 'getSyncedData':
        $token = $_REQUEST['token'];
        if($token == 'just_to_prevent_others_to_user_asdf1254609') {
            // Select into file for 4 tables
            $db_host = Config::get('db_main_host');
            $db_user = Config::get('db_main_user');
            $db_pass = Config::get('db_main_pass');
            $db_name = Config::get('db_main_dbname');

            $v_file = '/tmp/_Files.sql';
            $u_file = '/tmp/_users.sql';
            $t_file = '/tmp/_tags.sql';
            $tv_file = '/tmp/_tag_File.sql';

            $mysqldump = file_exists('/usr/local/bin/mysqldump') ? '/usr/local/bin/mysqldump' : null;
            $mysqldump = empty($mysqldump) && file_exists('/usr/bin/mysqldump') ? '/usr/bin/mysqldump' : $mysqldump;

            if(empty($mysqldump)) {
                echo "mysqldump command not found!";
                exit;
            }

            exec("$mysqldump -u$db_user -h$db_host -p$db_pass $db_name ".$pre."Files | grep -v 'Warning: Using a password' > $v_file 2>&1 ", $output, $return_var);
            exec("$mysqldump -u$db_user -h$db_host -p$db_pass $db_name ".$pre."users | grep -v 'Warning: Using a password' > $u_file 2>&1 ", $output, $return_var);
            exec("$mysqldump -u$db_user -h$db_host -p$db_pass $db_name ".$pre."tags | grep -v 'Warning: Using a password' > $t_file 2>&1 ", $output, $return_var);
            exec("$mysqldump -u$db_user -h$db_host -p$db_pass $db_name ".$pre."tag_File | grep -v 'Warning: Using a password' > $tv_file 2>&1 ", $output, $return_var);


            $syncDataFile = '/tmp/zzz_sync_data.zip';
            $zip = new ZipArchive;
            if ($zip->open($syncDataFile, ZipArchive::CREATE) === TRUE) {
                // Add files to the zip file
                $zip->addFile('/tmp/_Files.sql');
                $zip->addFile('/tmp/_users.sql');
                $zip->addFile('/tmp/_tags.sql');
                $zip->addFile('/tmp/_tag_File.sql');

                // All files are added, so close the zip file.
                $zip->close();

                unlink($v_file);
                unlink($u_file);
                unlink($t_file);
                unlink($tv_file);
            }

            // set download for the zip file
            header("Content-type: application/zip");
            header("Content-Disposition: attachment; filename=synced_data.zip");
            header("Content-length: " . filesize($syncDataFile));
            header("Pragma: no-cache");
            header("Expires: 0");
            readfile("$syncDataFile");

            exit;
        }

        break;


    case 'default':
        echo 'File api';
        break;
}

