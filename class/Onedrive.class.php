<?php

class Onedrive {

    const CLIENT_ID = '5e103147-910d-4a7c-816b-3e66d05e6296';
    const CLIENT_SECRET = 'QpywYs_N6-W5QEaWe1fYe1~8BmENGN~StX';
    const DRIVE_API_BASE_URL = 'https://graph.microsoft.com/v1.0';
    const OAUTH_API_BASE_URL = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';
    const TOKEN_FILE = __DIR__ . '/Onedrive_tokens.json';
    const CACHE_KEY = THEME . '_onedrive_tokens';

    private static $default_refresh_token = 'M.R3_BAY.-CWzFi2fZ5htedJiTT!fn8!yjw9oF5D*mL7ih8bIDVCGvg9n8L4xl2A*gmw5mtZ2Va4zDUvoF1XNOj8dJXsOqmwvKTWrdnbLjg!rGJkHPRDDPFIwGlvYtcI882o4A0JhIZNK6J4*bXFZrHKJ7GzxfnKJPXNlO5HR*TPZ5gSTHyDuDGehKqs*U5XQIxExH*EF8seppIism!0ibNogRqFfx!g*sWm!2Y2em3G7lIf4rxSg7IRP56AOSvTAxakSdNJrAR!VreYH2!o7B7L7ZqsxaB5M0BKJiHQCXNgUGihort9To24gl98bMx*u4wEnq7DrAYA$$';

    /**
     * Get access token from json file, if expired, refresh it
     *
     * @return void
     */
    public static function get_access_token() {
        $tokens = null;
        // Get tokens from memcache first if available
        if(APCU) {
            $res = apcu_fetch(self::CACHE_KEY);
            if(!empty($res)) {
                $tokens = $res;
            }
        }

        // If empty, then try to get tokens from session
        if( empty($tokens) && !empty($_SESSION[self::CACHE_KEY]) && !empty($_SESSION[self::CACHE_KEY]['access_token'])) {
            $tokens = $_SESSION[self::CACHE_KEY];
        }

        // If still empty, get from file
        if( empty($tokens) ) {
            $content = file_get_contents(self::TOKEN_FILE);
            $tokens = (array)json_decode($content);
        }

        if(empty($tokens['expires_timestamp']) || $tokens['expires_timestamp'] <= time()) {
            // access token has expired, refresh it
            $refresh_token = empty($tokens['refresh_token']) ? self::$default_refresh_token : $tokens['refresh_token'];
            $res = self::refresh_token($refresh_token);
            return $res->access_token;
        }
        else {
            return $tokens['access_token'];
        }
    }

    /**
     * Refresh token using refresh_token, and save it to json file
     * 
     * https://login.microsoftonline.com/common/oauth2/token?
     *    client_id={client_id}
     *    &client_secret={client_secret}
     *    &redirect_uri={redirect_uri}
     *    &refresh_token={refresh_token}
     *    &grant_type=refresh_token
     * 
     * @return object $json_object
     */
    public static function refresh_token($refresh_token = null) {
        $refresh_token = empty($refresh_token) ? self::$default_refresh_token : $refresh_token;
        $data = [
            'client_id' => self::CLIENT_ID,
            'client_secret' => self::CLIENT_SECRET,
            'redirect_uri' => 'https://local.tuzac.com/zzz.php',
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token',
        ];
        $url = self::OAUTH_API_BASE_URL;
        $res = curl_call($url, 'post', $data);

        $resObj = json_decode($res);
        if(!empty($resObj->access_token)) {
            $result = [
                'access_token' => $resObj->access_token,
                'refresh_token' => $resObj->refresh_token,
                'expires_timestamp' => time() + $resObj->expires_in - 300,
            ]; 
            file_put_contents(self::TOKEN_FILE, json_encode($result));
            // Put to memcaceh too
            if(APCU) {
                apcu_store($self::CACHE_KEY, $result, $resObj->expires_in);
            }
            // Also put to session
            $_SESSION[self::CACHE_KEY] = $result;
        }

        return $resObj;
    }


    /**
     * Upload photo to Onedrive
     *
     * @return bool $res
     */
    public static function upload_photo($jw_path, $force_replace = false) {
        $options = [ 'headers' => ["Authorization: Bearer " . Onedrive::get_access_token() ] ];

        // Make file_root not ending with "/jw-photos/" (has ending "/")
        $file_root = Config::get('file_root');
        if(empty($file_root)) {
            $file_root = $_SERVER['DOCUMENT_ROOT'] . '/jw-photos/';
        }
        if( strpos($file_root, 'jw-photos') == (strlen($file_root) - strlen('jw-photos/')) ) {
            $file_root = str_replace('/jw-photos/', '', $file_root);
        }

        // Make jw_path start with "/jw-photos"
        if( strpos($jw_path, '/jw-photos') !== 0 ) {
            $jw_path = '/jw-photos' . $jw_path;
        }

        $tmpArr = explode('/', $jw_path);
        $full_path = $file_root . $jw_path;
        $file_name = array_pop($tmpArr);
        $jw_folders = $tmpArr;

        // Check if item exists
        $url = self::DRIVE_API_BASE_URL . '/me/drive/root:' . urlencode($jw_path);
        $res = json_decode(curl_call($url,'get', null, $options));

        if(empty($res->id)) {
            // If it does not exist, upload it as new to the folder
            // Step 1: recursively check/create folders, and get the last level folder id
            $parent_id = self::makeDirectories($jw_folders);

            // Step 2: Put file to the folder using id as parent_id
            $url = self::DRIVE_API_BASE_URL . '/me/drive/items/' . $parent_id . ':/'. $file_name . ':/content';
            $res = json_decode(curl_call($url,'put', $full_path, $options));
            return !empty($res->id);
        }
        else {
            // If exists but set force_replace flag, replace it
            if($force_replace) {
                // Replace the file
                $url = self::DRIVE_API_BASE_URL . '/me/drive/items/' . $res->id . '/content';
                $res = json_decode(curl_call($url, 'put', $full_path, $options));
            }
            return !empty($res->id);
        }
    }

    public static function makeDirectories(array $folders, string $start_path = '', string $parent_id = null) {
        $options = [ 'headers' => ["Authorization: Bearer " . Onedrive::get_access_token() ] ];

        // Check if first-level folder exists
        $first = null;
        while ($first === null || $first === false || $first === '') {
            $first = array_shift($folders);
        } 
        $url = self::DRIVE_API_BASE_URL . '/me/drive/root:' . urlencode($start_path . '/' . $first);
        $res = json_decode(curl_call($url,'get', null, $options));
        if(empty($res->id)) {
            // If it does not exist, create it
            if(empty($parent_id)) {
                $url = self::DRIVE_API_BASE_URL . '/me/drive/root/children';
            }
            else {
                $url = self::DRIVE_API_BASE_URL . '/me/drive/items/' . $parent_id . '/children';
            }
            $data = [
                'name' => $first,
                'folder' => new stdClass(),
            ];

            $options['headers'][] = 'Content-Type: application/json';
            $res = json_decode(curl_call($url, 'post', json_encode($data), $options));
            if(empty($res->id)) {
                error_log('Create folder in Onedrive failed. Path: ' . $start_path . '/' . $first);
            }
            else {
                if(!empty($folders)) {
                    return self::makeDirectories($folders, $start_path . '/' . $first, $res->id);
                }
                else {
                    return $res->id;
                }
            }
        }
        else {
            // If exists, recursively call this function to check next level folder
            if(!empty($folders)) {
                return self::makeDirectories($folders, $start_path . '/' . $first, $res->id);
            }
            else {
                return $res->id;
            }
        }
    }

    /**
     * Get photo content by path
     *
     * @param string $path e.g.: /jw-photos/tujigu/秀人网/秀人网_小热巴《性感OL》-55P-/6.jpg
     * @return string $res - image binary data
     */
    public static function get_photo_content($path) {
        $options = [ 'headers' => ["Authorization: Bearer " . Onedrive::get_access_token() ] ];

        $url = self::DRIVE_API_BASE_URL . '/me/drive/root:' . urlencode($path) . ':/content';
        $res = curl_call($url,'get', null, $options);

        return $res;
    }



    public static function list_photos_in_folder($jw_path) {
        $options = [ 'headers' => ["Authorization: Bearer " . Onedrive::get_access_token() ] ];

        // Get item by path
        $url = self::DRIVE_API_BASE_URL . '/me/drive/root:/jw-photos' . urlencode($jw_path);
        $res = json_decode(curl_call($url,'get', null, $options));
        
        $url = self::DRIVE_API_BASE_URL . '/me/drive/items/' . $res->id . '/children';
        $res = json_decode(curl_call($url,'get', null, $options));
        
        return $res->value;
    }
}