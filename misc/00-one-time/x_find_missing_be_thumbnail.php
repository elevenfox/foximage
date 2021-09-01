<?php
require_once '../../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$pre = Config::get('db_table_prefix');

$file_id = isset($argv[1]) ? (int)$argv[1] : 0;


echo "#####################################\n";
echo date('Y-m-d H:i:s') . ' - ' . "Start re-handling tags for tujigu photos .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo "#####################################\n";

import('B2');
$b2 = new B2();

$num = 0;

// Get all rows which source is tujigu
$query = 'SELECT * FROM '. $pre . 'files where id in (11663,11718,31675)';

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        echo date('Y-m-d H:i:s') . ' - ' . ($num+1) . " - processing: id=" . $row['id'] .', '. $row['title'] . " \n";
        
        // Get B2 header of the thumbnail
        $physical_path = buildPhysicalPath($row);
        $base_b2_url = 'https://f002.backblazeb2.com/file/jw-photos-2021/';
        $file_root = Config::get('file_root');
        $relative_path = str_replace($file_root, '', $physical_path);
        $key = $relative_path . '/thumbnail.jpg';
        $img_src = $base_b2_url . str_replace('%2F','/', urlencode($key));
        $file_headers = @get_headers($img_src);
        if(!empty($file_headers) && strpos($file_headers[0], '200') !== false) 
        {
            echo date('Y-m-d H:i:s') . " ------- ok \n";
        }
        else {
            echo date('Y-m-d H:i:s') . " ------- \033[31m Not found! \033[39m ID=".$row['id'].": ".$row['title']." \n";
            echo date('Y-m-d H:i:s') . " ------- uploading ".$full_path." \n";
            $full_path = $physical_path . '/thumbnail.jpg';
            $res = $b2->upload_photo($key, $full_path);
        }
        $num++;
    }
}