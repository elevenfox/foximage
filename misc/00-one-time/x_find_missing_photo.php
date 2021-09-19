<?php
require_once '../../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$pre = Config::get('db_table_prefix');

$file_id = isset($argv[1]) ? (int)$argv[1] : 0;


echo "#####################################\n";
echo date('Y-m-d H:i:s') . ' - ' . "Start finding missing photos .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo "#####################################\n";

$num = 0;

// Get all rows which source is tujigu
$query = 'SELECT * FROM '. $pre . 'files order by id';

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        // Get photo count in DB row
        $images = explode(',', $row['filename']);
        $image_count_db = count($images);
        
        
        // Get physical file cound, minus one to exclude thumbnail
        $physical_path = buildPhysicalPath($row);
        $files = scandir($physical_path);
        $num_files = count($files)-3; // exclude . & .. & thumbnail
        

    
        // campare above two cound, if physical count less than db cound, we have missing photo
        if($num_files < $image_count_db) 
        {
            echo date('Y-m-d H:i:s') . ' - ' . ($num+1) . " - id=" . $row['id'] .', '. $row['title'] . " \n";
            echo date('Y-m-d H:i:s') . " ----- Photos in DB: " . count($images) . " \n";
            echo date('Y-m-d H:i:s') . " ----- Found " . $num_files . " photos in {$physical_path} \n";
            echo date('Y-m-d H:i:s') . " ------- \033[31m Found! \033[39m ID=".$row['id'].": ".$row['title']." \n";

            // figure out which one is missing, download it, and also try to upload to Onedrive
            foreach ($images as $img) {
                // Build local filename
                $name_arr = explode('/', $img);
                $filename = array_pop($name_arr);
                $fullname = $physical_path . '/' . $filename;
    
                // if file does not exist locally or force_download, then download it
                if(!file_exists($fullname)) {
                    echo date('Y-m-d H:i:s') . ' --------  downloading file: ' . $img . " \n";  
                    $referrer = getReferrer($row['source']);  
                    $result = curl_call($img, 'get', null, ['timeout' => 15, 'referrer'=>$referrer]);
                    if(!empty($result)) {
                        echo date('Y-m-d H:i:s') . " ------------ saving file: " . $fullname . " \n";    
                        $res = file_put_contents($fullname, $result);
                        if(!$res) {
                            echo date('Y-m-d H:i:s') . " ------------------ failed!!! \n";    
                        }
                        else {
                            echo date('Y-m-d H:i:s') . " ------------------ succes \n";    
                        }
                    }
                    else {
                        echo date('Y-m-d H:i:s') . " --------- \033[31m failed to download: " . $img . "\033[39m \n"; 
                    }
                }
            }
        }
        
        $num++;
        if ($num % 100 == 0) { 
            echo date('Y-m-d H:i:s') . ' - processed '. $num . ", last id=" . $row['id'] ." \n";
        }
    }
}