<?php
require('bootstrap.inc.php');

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

        // If no thumbnail.jpg, rename last image to thumbnail.jpg
        $scan2 = scandir($origin_full_path);
        $images = [];
        $already_has_thumbnail = false;
        foreach($scan2 as $file) {
            $origin_file_full = $origin_full_path . '/' . $file;
            if($file == 'thumbnail.JPG') {
                rename($origin_full_path . '/thumbnail.JPG' , $origin_full_path . '/thumbnail.jpg');
                $file = 'thumbnail.jpg';
            }
            if($file == 'cover.jpg') {
                rename($origin_full_path . '/cover.JPG' , $origin_full_path . '/thumbnail.jpg');
                $file = 'thumbnail.jpg';
            }
            if($file == 'thumbnail.jpg') {
                $already_has_thumbnail = true;
                break;
            }
        }
 
        if(!$already_has_thumbnail) {
            echo "No thumbnail in this folder: $folder_name \n";
        }

    }
    
}