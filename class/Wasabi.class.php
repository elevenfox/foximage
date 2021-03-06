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
}