<?php
require __DIR__ . '/aws/aws-autoloader.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class Wasabi {

    const AUTH_KEY = 'EYU1GVUSEFYLJESH9PXR';
    const AUTH_SECRET = 'h8KdCwErSBkNbjBVWaXzwhyTDzZgDVUeKJ9GfecW';
    const API_BASE_URL = 'https://s3.us-west-1.wasabisys.com';
    const BUCKET = 'jw-photos';

    private $w3;

    public function __construct() {
        $raw_credentials = array(
            'credentials' => [
                'key' => self::AUTH_KEY,
                'secret' => self::AUTH_SECRET,
            ],
            'endpoint' => self::API_BASE_URL,
            'region' => 'us-west-1', 
            'version' => 'latest',
            'use_path_style_endpoint' => true
         );
         
         $this->ws = S3Client::factory($raw_credentials);
    }
    

    /**
     * Get photo content by path
     *
     * @param string $relative_path e.g.: tujigu/秀人网/秀人网_小热巴《性感OL》-55P-/6.jpg
     * @return string $res - image binary data
     */
    public function get_photo_content($relative_path) {

        try {
            $res = $this->ws->getObject([
                'Bucket' => self::BUCKET,
                'Key' => $relative_path,
            ]);
            return $res;
        } 
        catch (S3Exception $e) {
            //error_log('-- Failed to get photo: ' . $e->getMessage() . PHP_EOL);
            return false;
        }
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