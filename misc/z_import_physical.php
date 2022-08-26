<?php
require_once '../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

###################### Define variables ################

$file_root = Config::get('file_root');
$pre = Config::get('db_table_prefix');

$folder_full_path = isset($argv[1]) ? $argv[1] : null;
if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}
###################### End of define variables ################


###################### Define functions ################
function file_db_exist($relative_path) {
	$res = File::getFileBySourceUrl($relative_path);

	if(!$res) {
		$res = File::getIgnoredFileBySourceUrl($relative_path);
	}

	return $res;
}
###################### end of define functions ################

echo  "#####################################\n";
echo  date('Y-m-d H:i:s') . ' - ' . "Start importing albums .... \n";
echo  date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo  date('Y-m-d H:i:s') . ' - ' . "-- for folder: " . $folder_full_path . " \n";
echo  "#####################################\n";

// Start importing to current (dev) site: build fileObj from physical files
echo date('Y-m-d H:i:s') . ' - ' . "-- importing: $folder_full_path \n";

$relative_path = str_replace($file_root, '', $folder_full_path);

$fileObj = new stdClass();
$fileObj->source = 'manual';
$fileObj->source_url = $relative_path;

// title
$fileObj->title = basename($folder_full_path);

// description
$fileObj->description = file_get_contents($folder_full_path.'/desc.txt');

// tags
$fileObj->tags = file_get_contents($folder_full_path.'/tags.txt');

// images
$physical_path = $folder_full_path;
$files = scandir($physical_path);
$num_images = 0;
$phy_images = [];
foreach ($files as $f) {
    if($f != '.' && $f != '..' && $f != 'thumbnail.jpg') {
        $extension = pathinfo($physical_path. '/' .$f, PATHINFO_EXTENSION);
        if($extension == 'jpg') {
            $phy_images[] = $f;
            $num_images++;
        }
    }
}

echo date('Y-m-d H:i:s') . '----- physical image count = ' . $num_images . "\n";

// Rename all images by 000 -> 999 number file name with a postfix to avoid override
$i = 1;
$new_file_name_arr = [];
$postfix = time();
foreach ($phy_images as $f) {
    $new_file_name = sprintf('%03d',$i) . '-'.$postfix.'.jpg';
    echo date('Y-m-d H:i:s') .  '----- change '.$f." to ".$new_file_name;
    $res = rename($physical_path.'/'.$f, $physical_path.'/'.$new_file_name);
    echo $res ? " 1 \n" : " 0 \n";
    $new_file_name_arr[] = $new_file_name;
    $i++;
}
// remove postfix
$i = 1;
$new_file_name_arr2 = [];
foreach ($new_file_name_arr as $nf) {
    $new_file_name = sprintf('%03d',$i) . '.jpg';
    echo date('Y-m-d H:i:s') .  '----- change '.$nf." to ".$new_file_name;
    $res = rename($physical_path.'/'.$nf, $physical_path.'/'.$new_file_name);
    echo $res ? " 1 \n" : " 0 \n";
    $new_file_name_arr2[] = $new_file_name;
    $i++;
}

$fileObj->images = $new_file_name_arr2;
$fileObj->thumbnail = 1;

$res = File::save($fileObj);
if($res) {
	// Process thumbnail
	processThumbnail((array)$fileObj, false, true);
	$status = 1;
}

$fileRowDB = file_db_exist($relative_path);
if($fileRowDB) {
	// Update the row in the database
	echo date('Y-m-d H:i:s') . "----- Update db row ...... \n";
	$query = 'update '. $pre . 'files set full_path=2, saved_locally=5  where id='.$fileRowDB['id'];
	DB::$dbInstance->getRows($query);
}