<?php
require_once '../bootstrap.inc.php';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

###################### Define variables ################

$file_root = Config::get('file_root');
$pre = Config::get('db_table_prefix');
$prod_api = Config::get('prod_api_url');

$folder_full_path = isset($argv[1]) ? $argv[1] : null;
$file_id = isset($argv[2]) ? (int)$argv[2] : 0;

if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}
$folder_full_path = str_replace(array("\r\n", "\r", "\n", "\t"), '', $folder_full_path);
###################### End of define variables ################


###################### Define functions ################
function file_db_exist($relative_path) {
	$res = File::getFileBySourceUrl($relative_path);

	// if(!$res) {
	// 	$res = File::getIgnoredFileBySourceUrl($relative_path);
	// }

	return $res;
}
###################### end of define functions ################

echo  "#####################################\n";
echo  date('Y-m-d H:i:s') . ' - ' . "Start importing albums .... \n";
echo  date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo  date('Y-m-d H:i:s') . ' - ' . "-- for folder: " . $folder_full_path . " \n";
echo  "#####################################\n";

if(empty($file_id)) {
    // Start importing to current (dev) site: build fileObj from physical files
    echo date('Y-m-d H:i:s') . ' - ' . "-- importing: $folder_full_path \n";
    $fileObj = new stdClass();
}
else {
    echo date('Y-m-d H:i:s') . ' - ' . "-- updating file_id = $file_id with folder: $folder_full_path \n";
    $fileObj = (object)File::getFileByID($file_id);
}

$relative_path = str_replace($file_root, '', $folder_full_path);


//$fileObj->source = 'manual';
$fileObj->source_url = $relative_path;

// Use first folder name of relative_path as the source
$fileObj->source = current(array_filter(explode('/', $relative_path)));

// title
$fileObj->title = basename($folder_full_path);

// description
$fileObj->description = file_get_contents($folder_full_path.'/desc.txt');
if(empty($fileObj->description)) {
    // echo date('Y-m-d H:i:s') . " - Must have a desc.txt file! \n";
    // exit;
    echo date('Y-m-d H:i:s') . " - Not found a desc.txt file, use title as desc. \n";
    $fileObj->description = str_replace('-', ' ',$fileObj->title);
}

// tags
$tags_str = file_get_contents($folder_full_path.'/tags.txt');
if(empty($tags_str)) {
    echo date('Y-m-d H:i:s') . " - Must have a tags.txt file! \n";
    exit;
}
$tags_str = str_replace("，", ",", $tags_str);
$fileObj->tags = $tags_str;


// Get download url if there is one
$download_url = file_get_contents($folder_full_path.'/dl.txt');
$fileObj->download_url = $download_url;

// check thumbnail
$thumbnail_full_path = $folder_full_path.'/thumbnail.jpg';
if(!file_exists($thumbnail_full_path)) {
    echo date('Y-m-d H:i:s') . " - Must have a thumbnail.jpg file! \n";
    exit;
}
else {
    // Check thumbnail size, if height bigger than 500px, then resize it
    list($t_width, $t_height) = getimagesize($thumbnail_full_path);
    // echo "width: " . $t_width . "<br />";
    // echo "height: " .  $t_height;
    if($t_height > 500) {
        // $t_image = imagecreatefromjpeg($thumbnail_full_path);
        // $imgResized = imagescale($t_image , 333, -1);
        // imagejpeg($imgResized, $thumbnail_full_path, 90); 
        smartResizeThumbnail($thumbnail_full_path);
    }
}

// images
$physical_path = $folder_full_path;
$files = scandir($physical_path);
$num_images = 0;
$phy_images = [];
foreach ($files as $f) {
    if($f != '.' && $f != '..' && $f != 'thumbnail.jpg' && substr($f, 0, 1) != ".") {
        $extension = pathinfo($physical_path. '/' .$f, PATHINFO_EXTENSION);
        if($extension == 'jpg' || $extension == 'JPG') {
            $phy_images[] = $f;
            $num_images++;
        }
    }
}

echo date('Y-m-d H:i:s') . '----- physical image count = ' . $num_images . "\n";
if($num_images <5) {
    echo date('Y-m-d H:i:s') . " - Must have more than 5 images to create an album! \n";
    exit;
}

// Rename all images by 000 -> 999 number file name with a postfix to avoid override
$i = 1;
$new_file_name_arr = [];
foreach ($phy_images as $f) {
    $postfix = substr(md5(microtime()),rand(0,26),5);
    $new_file_name = sprintf('%03d',$i) . '-'.$postfix.'.jpg';
    //echo date('Y-m-d H:i:s') .  '----- change '.$f." to ".$new_file_name;
    $res = rename($physical_path.'/'.$f, $physical_path.'/'.$new_file_name);
    echo $res ? " 1-" : " 0-";
    $new_file_name_arr[] = $new_file_name;
    $i++;
}
echo "\n";
echo date('Y-m-d H:i:s') . "------ done renaming images. \n";
// remove postfix
// $i = 1;
// $new_file_name_arr2 = [];
// foreach ($new_file_name_arr as $nf) {
//     $new_file_name = sprintf('%03d',$i) . '.jpg';
//     echo date('Y-m-d H:i:s') .  '----- change '.$nf." to ".$new_file_name;
//     $res = rename($physical_path.'/'.$nf, $physical_path.'/'.$new_file_name);
//     echo $res ? " 1 \n" : " 0 \n";
//     $new_file_name_arr2[] = $new_file_name;
//     $i++;
// }

$fileObj->images = $new_file_name_arr;
$fileObj->thumbnail = 1;

//echo "\n" . print_r($fileObj) . "\n";

$res = File::save($fileObj);
if($res) {
	// Process thumbnail
    echo date('Y-m-d H:i:s') .  '----- processing thumbnail... ' . "\n";
	processThumbnail((array)$fileObj, false, true);
	$status = 1;
}
else {
    echo date('Y-m-d H:i:s') .  '----- Failed to import album!' . "\n";
}

$fileRowDB = file_db_exist($relative_path);
if($fileRowDB) {
	// Update the row in the database
	echo date('Y-m-d H:i:s') . "----- Update db row ...... \n";
	$query = 'update '. $pre . 'files set full_path=2, saved_locally=5  where id='.$fileRowDB['id'];
	DB::$dbInstance->getRows($query);
}

// If file_id is not empty, call prod api to save to prod db too.
if(!empty($file_id)) {
    echo date('Y-m-d H:i:s') . '----- sync this to prod ...... ';
    $res2 = curl_call($prod_api.'?ac=save_file_data', 'post', array('obj'=>json_encode($fileObj)));
    echo $res2 . "\n";
}

