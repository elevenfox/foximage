<?php
require_once '../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$prod_api = Config::get('prod_api_url');

$folder_full_path = isset($argv[1]) ? $argv[1] : null;
if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}

echo "#####################################\n";
echo date('Y-m-d H:i:s') . ' - ' . "Start loop photos .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- in folder: " . $folder_full_path . " \n";
echo "#####################################\n";

// Get physical file cound, 
// exclude ., .., thumbnail.jpg, non-jpg files
$physical_path = $folder_full_path;
$files = scandir($physical_path);
$num_images = 0;
$phy_images = [];
foreach ($files as $f) {
    if($f != '.' && $f != '..' && $f != 'thumbnail.jpg') {
        $extension = pathinfo($physical_path. '/' .$f, PATHINFO_EXTENSION);
        if($extension == 'jpg' || $extension == 'JPG') {
            $phy_images[] = $f;
            $num_images++;
        }
    }
}

echo date('Y-m-d H:i:s') . '----- physical image count = ' . $num_images . "\n";

// Rename all images by 000 -> 999 number file name with a postfix to avoid override
$i = 1;
$new_file_name_arr = [];
foreach ($phy_images as $f) {
    $postfix = substr(md5(microtime()),rand(0,26),5);
    $new_file_name = sprintf('%03d',$i) . '-'.$postfix.'.jpg';
    echo date('Y-m-d H:i:s') .  '----- change '.$f." to ".$new_file_name;
    $res = rename($physical_path.'/'.$f, $physical_path.'/'.$new_file_name);
    echo $res ? " 1 \n" : " 0 \n";
    $new_file_name_arr[] = $new_file_name;
    $i++;
}
