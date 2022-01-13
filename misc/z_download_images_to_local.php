<?php

$fp = fopen("/tmp/z_download.lock", "r+");
if (flock($fp, LOCK_EX | LOCK_NB)) {  // 进行排它型锁定
// Runing job under a lock

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
$query = 'SELECT * FROM '. $pre . 'files where saved_locally is null limit 10';
//$query = 'SELECT * FROM '. $pre . 'files where saved_locally is null and source ="tujigu" and title like \'尤果%\' limit 1';
//$query = 'SELECT * FROM '. $pre . 'files where saved_locally is null and source ="tujigu" limit 1';
//$query = 'SELECT * FROM '. $pre . 'files where saved_locally is null and source ="tujigu" ORDER BY RAND() limit 1';

// If there is a force_file_id, query that file and re-download no matter what
if(!empty($force_file_id)) {
    $query = 'SELECT * FROM '. $pre . 'files where id = ' . $force_file_id;
}

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        echo date('Y-m-d H:i:s') . ' - ' . ($album_processed+1) . " - processing: id=" . $row['id'] .', '. $row['title'] . " \n";  
        
        // Build physical path: Use <file_root>/source/<file_title>/ as file structure
        //$physical_path = $file_root . $row['source'] . '/' . cleanStringForFilename($row['title']);
        $physical_path = buildPhysicalPath($row);

        // If folder not exist, create the folder
        if(!is_dir($physical_path)) {
            echo date('Y-m-d H:i:s') . " ----- creating directory: " . $physical_path . " \n";
            $res = mkdir($physical_path, 0744, true);
            if(!$res) {
                echo date('Y-m-d H:i:s') . " ----- failed to create directory: " . $physical_path . " \n";
            }
        }

        // Get all photo urls
        $photo_downloaded = 0;
        $images = explode(',', $row['filename']);
        echo date('Y-m-d H:i:s') . " ----- found photos: " . count($images) . " \n";
        foreach ($images as $img) {
            $img = str_replace('tjg.hywly.com', 'tjg.gzhuibei.com', $img);
            // Build local filename
            $name_arr = explode('/', $img);
            $filename = array_pop($name_arr);
            $fullname = $physical_path . '/' . $filename;

            // if file does not exist locally or force_download, then download it
            if(!file_exists($fullname) || !empty($force_file_id)) {
                echo date('Y-m-d H:i:s') . ' -------- ' . ($photo_downloaded+1) . " - downloading file: " . $img . " \n";  
                $referrer = getReferrer($row['source']);  
                $result = curl_call($img, 'get', null, ['timeout' => 15, 'referrer'=>$referrer]);
                if(!empty($result)) {
                    echo date('Y-m-d H:i:s') . " ------------ saving file: " . $fullname . " \n";    
                    $res = file_put_contents($fullname, $result);
                    if(!$res) {
                        echo date('Y-m-d H:i:s') . " ------------------ failed!!! \n";    
                    }
                    else {
                        $photo_downloaded++;
                        $photo_downloaded_total++;
                        echo date('Y-m-d H:i:s') . " ------------------ succes \n";    
                    }
                }
                else {
                    echo date('Y-m-d H:i:s') . " --------- \033[31m failed to download: " . $img . "\033[39m \n"; 
                }
            }
        }

        // Get files count under this folder
        $files = scandir($physical_path);
        $num_files = count($files)-2;
        // If files count >= images count in db, we are good to set saved-local to 1
        if($num_files >= count($images)) {
            $sql = "update ". $pre . "files set saved_locally=1 where id = '" . $row['id'] . "'";
            $res = DB::$dbInstance->query($sql);
            if(!$res) {
                echo date('Y-m-d H:i:s') . ' - ' . "---- \033[31m failed to update db record. \033[39m \n";        
            }
            else {
                echo date('Y-m-d H:i:s') . ' - ' . "---- Saved locally completed.\n";        
            }
        }

        $album_processed++;

        //break;
    }
}

echo "-----------------------------------\n";
echo date('Y-m-d H:i:s') . ' - ' . "Totally processed $album_processed albums, download $photo_downloaded_total photos \n";
echo "-----------------------------------\n\n";


} 
else {
    // previous script is running, do nothing.
    echo "- JOB is running, wait for next time! \n";
}
