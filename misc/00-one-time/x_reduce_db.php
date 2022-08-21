<?php
require_once '../../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$pre = Config::get('db_table_prefix');

$file_id = isset($argv[1]) ? (int)$argv[1] : 0;


echo "#####################################\n";
echo date('Y-m-d H:i:s') . ' - ' . "Start loop photos .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo "#####################################\n";

$num = 0;

// Get all rows which source is tujigu
$query = 'SELECT * FROM '. $pre . 'files where full_path  is null  order by id';

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        // Get filename, explode by ","
        $images = explode(',', $row['filename']);
        $image_count_db = count($images);
        
        // Get physical file cound, 
        // exclude ., .., thumbnail.jpg, non-jpg files
        // $physical_path = buildPhysicalPath($row);
        // $files = scandir($physical_path);
        // $num_files = count($files)-3; // exclude . & .. & thumbnail
        
        echo date('Y-m-d H:i:s') . ' - ' . ($num+1) . " - id=" . $row['id'] .', '. $row['title'] . " \n";
        echo date('Y-m-d H:i:s') . " ----- Photos in DB: " . count($images) . " \n";
        // echo date('Y-m-d H:i:s') . " ----- Found " . $num_files . " photos in {$physical_path} \n";
        // echo date('Y-m-d H:i:s') . " ------- \033[31m Found! \033[39m ID=".$row['id'].": ".$row['title']." \n";
        echo date('Y-m-d H:i:s') . " ----- processing \n";

        // Remove url, only leave file name, to build the new filename array
        $new_filename_arr = []; 
        foreach ($images as $img) {
            // Build local filename
            $name_arr = explode('/', $img);
            $filename = array_pop($name_arr);
            
            $new_filename_arr[] = $filename;
        }
        
        // Update the row in the database
        $query = 'update '. $pre . 'files set filename="'.implode(',', $new_filename_arr).'",full_path=2  where id='.$row['id'];
        DB::$dbInstance->getRows($query);
        //echo $query; exit;
        
        $num++;
        if ($num % 100 == 0) { 
            echo date('Y-m-d H:i:s') . ' - processed '. $num . ", last id=" . $row['id'] ." \n";
        }
    }
}