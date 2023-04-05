<?php

require_once '../bootstrap.inc.php';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ERROR);

###################### Define variables ################

$file_root = Config::get('file_root');
$pre = Config::get('db_table_prefix');

$file_ids = isset($argv[1]) ? $argv[1] : null;

if(empty($file_ids)) {
    echo "---- Must have at least one file id as the param! \n";
    exit;
}


echo date('Y-m-d H:i:s') . ' - ' . " Start regenerating ... \n\n";
$start_time = time();

// read from Files
$x = 1;
$ids = explode(',', $file_ids);
foreach ($ids as $id) {
    echo date('Y-m-d H:i:s') . ' - ' . $x . " Processing for: ".$id." ... \n";

    // calling File::save will update File with clean tags also save to tags and tag_File
    $fileObj = File::getFileByID($id);
    $res = File::save((object)$fileObj);

    $result = empty($res) ? 'failed' : 'success';
    echo date('Y-m-d H:i:s') . ' - ' . " ----------------- $result  \n";

    $x++;
}


$end_time = time();
$minutes = ceil(($end_time - $start_time) / 60);

echo "Total time: $minutes minutes, total processed albums: $x \n\n";




