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
$query = 'SELECT * FROM '. $pre . 'files where thumbnail != "local" and source="qqc"';

// If there is a force_file_id, query that file and re-download no matter what
if(!empty($force_file_id)) {
    $query = 'SELECT * FROM '. $pre . 'files where id = ' . $force_file_id;
}

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        echo date('Y-m-d H:i:s') . ' - ' . ($album_processed+1) . " - processing: id=" . $row['id'] .', '. $row['title'] . " \n";  

        // Build physical path: Use <file_root>/source/<file_title>/ as file structure
        $physical_path = buildPhysicalPath($row, '/home/eric/work/foximage/jw-photos/');

        // If folder not exist, create the folder
        if(!is_dir($physical_path)) {
            $res = mkdir($physical_path, 0755, true);
            if(!$res) {
                echo(" ----- failed to create directory: " . $physical_path ." \n");
            }
        }

        $fullname = $physical_path . '/thumbnail.jpg';
        // if file does not exist locally or force_download, then download it
        if(!file_exists($fullname)) {
          $referrer = getReferrer($row['source']);  
          $result = curl_call(str_replace('http://', 'https://', $row['thumbnail']), 'get', null, ['timeout'=>15,'referrer'=>$referrer]);
          if(!empty($result)) {
              echo " ------------ saving file: " . $fullname . " \n"; 
              $res = file_put_contents($fullname, $result);
              chmod($fullname, 0755);
              if(!$res) {
                  echo(" ----- failed to save thumbnail: " . $fullname ." \n");    
              }
              else {
                $query = 'update ' . $pre . 'files set thumbnail="local" where id='.$row['id'];
                DB::$dbInstance->query($query);
                echo "----- success \n";
              }
          }
          else {
              echo(" ---- failed to download: " . $row['thumbnail']  ." \n"); 
          }
        }
        else {
            echo "---- thumbnail exists. {$fullname} \n";
        }
        
        $album_processed ++;
    }
}

echo "-----------------------------------\n";
echo date('Y-m-d H:i:s') . ' - ' . "Totally processed $album_processed albums \n";
echo "-----------------------------------\n\n";