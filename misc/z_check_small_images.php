<?php
require('../bootstrap.inc.php');

$folder_full_path = isset($argv[1]) ? $argv[1] : null;

if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}

$path = $folder_full_path;
$scan = scandir($path);
foreach($scan as $folder_name) {
    $origin_full_path = $path . '/'. $folder_name;
    
    if (is_dir($origin_full_path) && $folder_name!='.' && $folder_name!='..') {
        //echo '-- Processing folder: ' . $folder_name . "\n";

        $scan2 = scandir($origin_full_path);
        $small_images = [];
        foreach($scan2 as $file) {
            $origin_file_full = $origin_full_path . '/' . $file;
            $ext = pathinfo($origin_file_full, PATHINFO_EXTENSION);
            
            if($file != 'thumbnail.jpg' && $ext == 'jpg') {
                $size = filesize($origin_file_full);
                if($size < 100000) {
                    $small_images[$file] = $size;
                }
            }
        }
 
        if(count($small_images) > 0) {
            echo "Small files in this folder: $folder_name \n";
            foreach($small_images as $f=>$s) {
                echo "---- $f : $s \n";
            }
        }

    }
    
}