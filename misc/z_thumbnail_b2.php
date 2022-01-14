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

        // Build b2 key
        $physical_path = buildPhysicalPath($row);
        if(empty($file_root)) {
            $file_root = $_SERVER['DOCUMENT_ROOT'] . '/jw-photos/';
        }
        $relative_path = str_replace($file_root, '', $physical_path);
        $key = $relative_path . '/thumbnail.jpg';

        // Make sure thumbnail is in local filesystem
        // -- If folder not exist, create the folder
        if(!is_dir($physical_path)) {
            $res = mkdir($physical_path, 0755, true);
            if(!$res) {
                error_log(" ----- failed to create directory: " . $physical_path );
            }
        }

        $fullname = $physical_path . '/thumbnail.jpg';
        // -- if file does not exist locally, then download it
        if(!file_exists($fullname)) {
            $referrer = getReferrer($row['source']);  
            $tn_url = str_replace('http://', 'https://', $row['thumbnail']);
            $tn_url = str_replace('tjg.hywly.com', 'tjg.gzhuibei.com', $tn_url);
            $result = curl_call($tn_url, 'get', null, ['timeout'=>10,'referrer'=>$referrer]);
            if(!empty($result)) {
                $res = file_put_contents($fullname, $result);
                chmod($fullname, 0755);
                if(!$res) {
                    error_log(" ----- failed to save thumbnail: " . $fullname);    
                }
            }
            else {
                error_log(" ---- failed to download: " . $tn_url ); 
            }
        }

        // Upload to b2 if not exist
        if(file_exists($fullname)) {
            // Upload to B2
            import('B2');
            $b2 = new B2();
            $res = $b2->get_photo_content($key);
            if(empty($res)) {
                $res = $b2->upload_photo($key, $fullname);
                if(empty($res)) {
                    echo date('Y-m-d H:i:s') . " ------------ \033[31m failed \033[39m \n";  
                }
                else {
                    echo date('Y-m-d H:i:s') . " ------------ Success \n";  
                }
            }

            // Update db to set thumbnail field to 1
            $pre = Config::get('db_table_prefix');
            $sql = "update ". $pre . "files set thumbnail=1 where source_url = '" . $row['source_url'] . "'";
            DB::$dbInstance->query($sql);
        }
        else {
            echo date('Y-m-d H:i:s') . " ------------ \033[31m local thumbnail not found \033[39m \n";  
        }

        $album_processed ++;
    }
}

echo "-----------------------------------\n";
echo date('Y-m-d H:i:s') . ' - ' . "Totally processed $album_processed albums \n";
echo "-----------------------------------\n\n";