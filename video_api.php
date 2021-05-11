<?php
require_once './bootstrap.inc';

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

import('dao.Video');

$pre = Config::get('db_table_prefix');

$action = empty($_REQUEST['ac']) ? 'default' : $_REQUEST['ac'];

switch($action) {
    case 'get_max_video_id':
        echo Video::getMaxVideoId();
        break;

    case 'video_exist':
        $url = $_GET['url'];
        $res = Video::getVideoBySourceUrl($url);
        echo empty($res) ? null : $res['id'];
        break;

    case 'get_video_by_key':
        $key = $_GET['key'];
        $result = Video::getVideoByMd5($key);
        $video = empty($result) ? null : $result;
        echo json_encode($video);
        break;

    case 'save_video_data':
    case 'save_video_data_and_node':
        $videoObj = json_decode($_POST['obj']);
        if(empty($videoObj)) {
            $post = json_decode(file_get_contents("php://input"));
            $videoObj = $post->obj;
        }

        if($videoObj->duration < 90) {
            error_log("Do not save video which has duration less than 90 seconds.");
            echo 0;
            return false;
        }

        // Save all info to videos table
        $res = Video::save($videoObj);

        echo $res ? 1 : 0;
        break;

    case 'save_proxy':
        if(!empty($_POST['obj'])) {
            $res = file_put_contents('./proxy_pool.txt', $_POST['obj']);
            if(empty($res)) {
                echo 'Failed to save proxy to file!';
            }
            else {
                $to_save = json_decode($_POST['obj']);
                echo "Ok, saved proxy pool, count: " . count($to_save);
            }
        }
        else {
            echo 0;
        }
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

    case 'upload_video_by_user':
        $res = false;

        $videoUrl = $_POST['videoUrl'];

        // Make sure can only delete video owned by current user
        if(!empty($_SESSION['user'])) {
            $data = ['url' => $videoUrl];
            $api_server = Config::get('api_server');
            $imv_url = $api_server . '/parse_video_by_url/';
            try {
                $result = json_decode(curl_call($imv_url, 'post', $data));
                $parseStatus = $result->status;
                if ($parseStatus) {
                    $vObj = $result->result;
                    $res = Video::save($vObj, $_SESSION['user']['name']);
                }
            } catch (Exception $e) {
                error_log($e->getMessage());
                $res = $e->getMessage();
            }
        }
        apiReturnJson($res);
        break;

    case 'delete_video_by_user':
        $res = false;

        $video_md5_id = $_POST['video_md5_id'];
        // Make sure can only delete video owned by current user
        if(!empty($_SESSION['user'])) {
            $video = Video::getVideoByMd5($video_md5_id);
            if(!empty($video) && ($video['user_name'] == $_SESSION['user']['name'] || isAdmin()) ) {
                $res = Video::deleteByMd5($video_md5_id);
            }
        }

        apiReturnJson($res);
        break;

    case 'delete_video_by_admin_opln35lmz9517sdjf':
        $res = false;

        $video_md5_id = $_POST['video_md5_id'];
        $token = $_POST['d_token'];
        if( !empty($token) && $token == Config::get('db_driver') ) {
            $res = Video::deleteByMd5($video_md5_id);
        }

        apiReturnJson($res);
        break;

    case 'mark_video_for_deleting_kgdfur35fjgf9517lsdmh':
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
            $res = Video::markForDeleting($source_url);
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

            $v_file = '/tmp/_videos.sql';
            $u_file = '/tmp/_users.sql';
            $t_file = '/tmp/_tags.sql';
            $tv_file = '/tmp/_tag_video.sql';

            $mysqldump = file_exists('/usr/local/bin/mysqldump') ? '/usr/local/bin/mysqldump' : null;
            $mysqldump = empty($mysqldump) && file_exists('/usr/bin/mysqldump') ? '/usr/bin/mysqldump' : $mysqldump;

            if(empty($mysqldump)) {
                echo "mysqldump command not found!";
                exit;
            }

            exec("$mysqldump -u$db_user -h$db_host -p$db_pass $db_name ".$pre."videos | grep -v 'Warning: Using a password' > $v_file 2>&1 ", $output, $return_var);
            exec("$mysqldump -u$db_user -h$db_host -p$db_pass $db_name ".$pre."users | grep -v 'Warning: Using a password' > $u_file 2>&1 ", $output, $return_var);
            exec("$mysqldump -u$db_user -h$db_host -p$db_pass $db_name ".$pre."tags | grep -v 'Warning: Using a password' > $t_file 2>&1 ", $output, $return_var);
            exec("$mysqldump -u$db_user -h$db_host -p$db_pass $db_name ".$pre."tag_video | grep -v 'Warning: Using a password' > $tv_file 2>&1 ", $output, $return_var);


            $syncDataFile = '/tmp/zzz_sync_data.zip';
            $zip = new ZipArchive;
            if ($zip->open($syncDataFile, ZipArchive::CREATE) === TRUE) {
                // Add files to the zip file
                $zip->addFile('/tmp/_videos.sql');
                $zip->addFile('/tmp/_users.sql');
                $zip->addFile('/tmp/_tags.sql');
                $zip->addFile('/tmp/_tag_video.sql');

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
        echo 'video api';
        break;
}

