<?php

require_once '../bootstrap.inc.php';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);


###################### Define variables ################

$file_root = Config::get('file_root');
$pre = Config::get('db_table_prefix');

$force_file_id = isset($argv[1]) ? (int)$argv[1] : null;

###################### End of define variables ################


echo "#####################################\n";
echo date('Y-m-d H:i:s') . ' - ' . "Start processing thumbnails .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo "#####################################\n";



$album_processed = 0;

// Readout db files records which `saved_locally` is null
$query = 'SELECT * FROM '. $pre . 'files where thumbnail != "1"';

// If there is a force_file_id, query that file and re-download no matter what
if(!empty($force_file_id)) {
    $query = 'SELECT * FROM '. $pre . 'files where id = ' . $force_file_id;
}

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        echo date('Y-m-d H:i:s') . ' - ' . ($album_processed+1) . " - processing: id=" . $row['id'] .', '. $row['title'] . " \n";  

        $res = processThumbnail($row);
        if(empty($res)) {
            echo date('Y-m-d H:i:s') . " ------------ \033[31m failed \033[39m \n";  
        }
        else {
            echo date('Y-m-d H:i:s') . " ------------ Success \n";  
        }
        
        $album_processed ++;
    }
}

echo "-----------------------------------\n";
echo date('Y-m-d H:i:s') . ' - ' . "Totally processed $album_processed albums \n";
echo "-----------------------------------\n\n";