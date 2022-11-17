<?php

$fp = fopen("/tmp/z_download.lock", "r+");
if (flock($fp, LOCK_EX | LOCK_NB)) {  // 进行排它型锁定
// Runing job under a lock

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
echo date('Y-m-d H:i:s') . ' - ' . "Start downloading photos .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo "#####################################\n";


$photo_downloaded_total = 0;
$album_processed = 0;

// Readout db files records which `saved_locally` is null
$query = 'SELECT * FROM '. $pre . 'files where saved_locally is null limit 100';
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
        $i = 0;
        foreach ($images as $img) {
            $img = str_replace('tjg.hywly.com', 'tjg.gzhuibei.com', $img);
            // Build local filename
            $name_arr = explode('/', $img);
            $filename = array_pop($name_arr);
            // if filename has no extention name, use leading-zero-number.jpg
            if(strpos($filename, '.jpg') === false) {
                $filename = sprintf('%03d', $i) . '.jpg';
            }
            $fullname = $physical_path . '/' . $filename;

            // if file does not exist locally or force_download, then download it
            if(!file_exists($fullname) || !empty($force_file_id)) {
                echo date('Y-m-d H:i:s') . ' -------- ' . ($photo_downloaded+1) . " - downloading file: " . $img . " \n";  
                $referrer = getReferrer($row['source']);  
                $result = curl_call($img, 'get', null, ['timeout' => 15, 'referrer'=>$referrer]);
                if(!empty($result)) {
                    echo date('Y-m-d H:i:s') . " ------------ saving file: " . $fullname . " \n";    
                    $res = file_put_contents($fullname, $result);
                    // If thumbnail_url shows it's a webp file, convert it to jpg
                    convert_webp_to_jpg($img, $fullname);
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

            $i++;
        }

        // Get files count under this folder
        $files = scandir($physical_path);
        $num_files = 0;
        $phy_images = [];
        foreach ($files as $f) {
            if($f != '.' && $f != '..' && $f != 'thumbnail.jpg') {
                $extension = pathinfo($physical_path. '/' .$f, PATHINFO_EXTENSION);
                if($extension == 'jpg') {
                    $phy_images[] = $f;
                    $num_files++;
                }
            }
        }

        // If files count >= images count in db, we are good to set saved-local to 1
        if($num_files >= count($images)) {
            // No matter what are the photo file names, make them starts with 001.jpg to max number
            // Rename all images by 000 -> 999 number file name with a postfix to avoid override
            $i = 1;
            $new_file_name_arr = [];
            $postfix = time();
            foreach ($phy_images as $f) {
                $new_file_name = sprintf('%03d',$i) . '-'.$postfix.'.jpg';
                //echo date('Y-m-d H:i:s') .  '----- change '.$f." to ".$new_file_name;
                $res = rename($physical_path.'/'.$f, $physical_path.'/'.$new_file_name);
                //echo $res ? " 1 \n" : " 0 \n";
                $new_file_name_arr[] = $new_file_name;
                $i++;
            }
            // remove postfix
            $i = 1;
            $new_file_name_arr2 = [];
            foreach ($new_file_name_arr as $nf) {
                $new_file_name = sprintf('%03d',$i) . '.jpg';
                //echo date('Y-m-d H:i:s') .  '----- change '.$nf." to ".$new_file_name;
                $res = rename($physical_path.'/'.$nf, $physical_path.'/'.$new_file_name);
                //echo $res ? " 1 \n" : " 0 \n";
                $new_file_name_arr2[] = $new_file_name;
                $i++;
            }

            // Update db to set filenames to short one and saved_local to 1
            $sql = 'update '. $pre . 'files set filename="'.implode(',', $new_file_name_arr2).'",saved_locally=5,full_path=2 where id = ' . $row['id'];
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
