<?php

require_once '../bootstrap.inc.php';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);


###################### Define variables ################

$file_root = Config::get('file_root');
$pre = Config::get('db_table_prefix');

$file_ids = isset($argv[1]) ? $argv[1] : null;

if(empty($file_ids)) {
    echo "---- Must have at least one file id as the param! \n";
    exit;
}

###################### End of define variables ################


echo "#####################################\n";
echo date('Y-m-d H:i:s') . ' - ' . "Start processing thumbnails .... \n";
echo "#####################################\n";

$ids = explode(',', $file_ids);

$album_processed = 0;
foreach($ids as $id) {
    $album_processed++;
    echo date('Y-m-d H:i:s') . ' - ' . $album_processed . " --- processing $id \n";    
    uploadB2Thumbnail(trim($id), true);
}

echo "-----------------------------------\n";
echo date('Y-m-d H:i:s') . ' - ' . "Totally processed $album_processed albums \n";
echo "-----------------------------------\n\n";