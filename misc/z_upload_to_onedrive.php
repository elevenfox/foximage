<?php

$fp = fopen("/tmp/z_upload.lock", "r+");
if (flock($fp, LOCK_EX | LOCK_NB)) {  // 进行排它型锁定
// Runing job under a lock

require_once '../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

import('Onedrive');

###################### Define variables ################

$file_root = Config::get('file_root');
$pre = Config::get('db_table_prefix');

$force_file_id = isset($argv[1]) ? (int)$argv[1] : null;


###################### End of define variables ################


echo "#####################################\n";
echo date('Y-m-d H:i:s') . ' - ' . "Start uploading photos .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo "#####################################\n";


$photo_uploaded_total = 0;
$album_processed = 0;

// Readout db files records which `saved_locally` != 2
//$query = 'SELECT * FROM '. $pre . 'files where saved_locally != 2 limit 1';
//$query = 'SELECT * FROM '. $pre . 'files where saved_locally != 2 and source ="tujigu" and title like \'尤果%\' limit 1';
$query = 'SELECT * FROM '. $pre . 'files where saved_locally != 2 and source ="tujigu" limit 1';
//$query = 'SELECT * FROM '. $pre . 'files where saved_locally != 2 and source ="tujigu" ORDER BY RAND() limit 1';

// If there is a force_file_id, query that file and re-download no matter what
if(!empty($force_file_id)) {
    $query = 'SELECT * FROM '. $pre . 'files where id = ' . $force_file_id;
}

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        echo date('Y-m-d H:i:s') . ' - ' . ($album_processed+1) . " - processing: id=" . $row['id'] .', '. $row['title'] . " \n";  
        
        // Build physical path: Use <file_root>/source/<file_title>/ as file structure
        $physical_path = buildPhysicalPath($row);

        // Get all photo urls
        $photo_uploaded = 0;
        $images = explode(',', $row['filename']);
        echo date('Y-m-d H:i:s') . " ----- found photos: " . count($images) . " \n";
        foreach ($images as $img) {
            // Build local filename
            $name_arr = explode('/', $img);
            $filename = array_pop($name_arr);
            $fullname = $physical_path . '/' . $filename;

            $relative_path = str_replace($file_root, '', $physical_path);
            $relative_fullname = '/jw-photos/' . $relative_path . '/' . $filename;

            // if file exist locally, then upload it
            if(file_exists($fullname)) {
                // upload it to onedrive
                echo date('Y-m-d H:i:s') . ' -------- ' . ($photo_uploaded+1) . " - uploading file: " . $fullname . " \n"; 
                $res = Onedrive::upload_photo($relative_fullname);
                if(!$res) {
                    echo date('Y-m-d H:i:s') . " ------------------ failed!!! \n";    
                }
                else {
                    $photo_uploaded_total++;
                    echo date('Y-m-d H:i:s') . " ------------------ succes \n";    
                }
                $photo_uploaded++;
            }
        }

        // Get files count under this folder
        $files = Onedrive::list_photos_in_folder('/' . $relative_path);
        $num_files = count($files);
        echo date('Y-m-d H:i:s') . '- found '. $num_files . ' in /' . $relative_path . ' on Onedrive.' . " \n";
        // If files count >= images count in db, we are good to set saved-local to 1
        if($num_files >= count($images)) {
            $sql = "update ". $pre . "files set saved_locally=2 where id = '" . $row['id'] . "'";
            $res = DB::$dbInstance->query($sql);
            if(!$res) {
                echo date('Y-m-d H:i:s') . ' - ' . "---- \033[31m failed to update db record. \033[39m \n";        
            }
            else {
                echo date('Y-m-d H:i:s') . ' - ' . "---- Saved locally completed.\n";        
            }
        }

        $album_processed++;
    }
}

echo "-----------------------------------\n";
echo date('Y-m-d H:i:s') . ' - ' . "Totally processed $album_processed albums, upload $photo_uploaded_total photos \n";
echo "-----------------------------------\n\n";


} 
else {
    // previous script is running, do nothing.
    echo "- JOB is running, wait for next time! \n";
}
