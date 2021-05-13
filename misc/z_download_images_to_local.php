<?php

require_once '../bootstrap.inc';

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
echo date('Y-m-d H:i:s') . ' - ' . "Start downloading photos .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo "#####################################\n";


$photo_downloaded_total = 0;
$album_processed = 0;

// Readout db files records which `saved_locally` is null
$query = 'SELECT * FROM '. $pre . 'files where saved_locally is null';

// If there is a force_file_id, query that file and re-download no matter what
if(!empty($force_file_id)) {
    $query = 'SELECT * FROM '. $pre . 'files where id = ' . $force_file_id;
}

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        echo date('Y-m-d H:i:s') . ' - ' . ($album_processed+1) . " -- processing: id=" . $row['id'] .', '. $row['title'] . " \n";  
        // Use <file_root>/source/<file_title>/ as file structure
        $physical_path = $file_root . $row['source'] . '/' . cleanStringForFilename($row['title']);
        if(!is_dir($physical_path) || !empty($force_file_id)) {
            // If folder not exist, create the folder, then get all images url, download them to the folder
            if(empty($force_file_id)) {
                echo date('Y-m-d H:i:s') . ' -' . "---- creating directory: " . $physical_path . " \n";
                $res = mkdir($physical_path, 0744, true);
            }
            else {
                $res = true;
            }

            if($res) {
                $photo_downloaded = 0;
                $images = explode(',', $row['filename']);
                echo date('Y-m-d H:i:s') . ' -' . "------ found photos: " . count($images) . " \n";
                foreach ($images as $img) {
                    $name_arr = explode('/', $img);
                    $filename = array_pop($name_arr);
                    $fullname = $physical_path . '/' . $filename;
             
                    $result = curl_call($img);
                    if(!empty($result)) {
                        echo date('Y-m-d H:i:s') . ' --------' . ($photo_downloaded+1) . " - saving file: " . $fullname . " \n";    
                        $res = file_put_contents($fullname, $result);
                        if(!$res) {
                            echo date('Y-m-d H:i:s') . ' - ' . "------------ failed!!! \n";    
                        }
                        else {
                            $photo_downloaded++;
                            $photo_downloaded_total++;
                            echo date('Y-m-d H:i:s') . ' - ' . "------------ succes \n";    
                        }
                    }
                    else {
                        echo date('Y-m-d H:i:s') . ' - ' . "-------- failed to download: " . $img . " \n"; 
                    }
                    
                }

                // then update record `saved_locally` to 1
                if($photo_downloaded == count($images)) {
                    $sql = "update ". $pre . "files set saved_locally=1 where id = '" . $row['id'] . "'";
                    $res = DB::$dbInstance->query($sql);
                    if(!$res) {
                        echo date('Y-m-d H:i:s') . ' - ' . "---- failed to update db record.\n";        
                    }
                }
            }
            else {
                echo date('Y-m-d H:i:s') . ' - ' . "---- failed to create directory: " . $physical_path . " \n";
            }
        }

        $album_processed++;

        break;
    }
}

echo "-----------------------------------\n";
echo date('Y-m-d H:i:s') . ' - ' . "Totally processed $album_processed albums, download $photo_downloaded_total photos \n";
echo "-----------------------------------\n\n";


