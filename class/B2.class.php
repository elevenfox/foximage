<?php
require __DIR__ . '/aws/aws-autoloader.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class B2 {

    const AUTH_KEY = '0025de4d4aa3fd80000000001';
    const AUTH_SECRET = 'K0026ARy2BcpApvC6ziNUnMmpZGZmJQ';
    const API_BASE_URL = 'https://s3.us-west-002.backblazeb2.com';
    const BUCKET = 'jw-photos-2021';

    private $b2;

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
         
         $this->b2 = S3Client::factory($raw_credentials);
    }
    

    /**
     * Get photo content by path
     *
     * @param string $relative_path e.g.: tujigu/秀人网/秀人网_小热巴《性感OL》-55P-/6.jpg
     * @return string $res - image binary data
     */
    public function get_photo_content($relative_path) {
        try {
            $res = $this->b2->getObject([
                'Bucket' => self::BUCKET,
                'Key' => $relative_path
            ]);
            return $res;
        } 
        catch (S3Exception $e) {
            //error_log('-- Failed to get photo: ' . $e->getMessage() . PHP_EOL);
            return false;
        }
    }

    public function upload_photo($relative_path, $source_file) {
        try {
            $res = $this->b2->putObject([
                'Bucket' => self::BUCKET,
                'Key' => $relative_path,
                'SourceFile' => $source_file
            ]);
            return $res;
        } 
        catch (S3Exception $e) {
            error_log('-- Failed to upload photo: ' . $e->getMessage() . PHP_EOL);
            return false;
        }
    }
}