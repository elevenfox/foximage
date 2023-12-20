<?php
require_once realpath(dirname(__FILE__)).'/../bootstrap.inc.php';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);


if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        if(strpos($haystack, $needle) === false) return false;
        else return true;
    }
}

###################### Define variables ################

$folder_full_path = isset($argv[1]) ? $argv[1] : null;
if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}

###################### End of define variables ################


echo  "#####################################\n";
echo  date('Y-m-d H:i:s') . ' - ' . "Start processing album: $folder_full_path .... \n";
echo  "#####################################\n";


$folder_name = basename($folder_full_path);

// Cleanup junk files and Handle thumbnail.jpg
$scan2 = scandir($folder_full_path);
$images = [];
$already_has_thumbnail = false;
foreach($scan2 as $file) {
    $origin_file_full = $folder_full_path . '/' . $file;
    if(strpos($file, '本套图来自') !== false) {
        unlink($origin_file_full);
    }
    if(strpos($file, '更多百度搜索') !== false) {
        unlink($origin_file_full);
    }
    if(strpos($file, '永久地址') !== false) {
        unlink($origin_file_full);
    }
    if(strpos($file, 'BestGirlSexy') !== false) {
        unlink($origin_file_full);
    }
    if($file == 'cover.jpg' || $file == 'cover.JPG') {
        rename($origin_file_full, $folder_full_path . '/thumbnail.jpg');
        $file = 'thumbnail.jpg';
    }
    if($file == 'thumbnail.JPG') {
        rename($origin_file_full, $folder_full_path . '/thumbnail.jpg');
        $file = 'thumbnail.jpg';
    }
    if($file == 'thumbnail.jpg') $already_has_thumbnail = true;
    if(!$already_has_thumbnail) {
        if ( is_file($origin_file_full) && @is_array(getimagesize($origin_file_full)) ) {
            $images[] = $file;
        }
    }
}
if($already_has_thumbnail) {
    echo "---- Already has a thumbnail.jpg \n\n";
}
else {
    natsort($images);
    
    $gen_thumb_rule = 1;
    switch($gen_thumb_rule) {
        case 1:
            // Use first image as thumbnail
            $thumb = $images[0];
            break;
        case 2:
            // Use last image as thumbnail
            $thumb = $images[count($images) - 1];
            break;
        case 3:
            // Get first portrait image
            foreach ($images as $im) {
                if(isImagePortrait($folder_full_path.'/'.$im)) {
                    $thumb = $im;
                    break;
                }
            }               
    }
    
    echo 'copy('. $folder_full_path . '/' . $thumb . ', ' . $folder_full_path . '/thumbnail.jpg' .  "\n\n";
    copy($folder_full_path . '/' . $thumb , $folder_full_path . '/thumbnail.jpg');    
}

echo " \n";