<?php
require_once '../bootstrap.inc.php';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$pre = Config::get('db_table_prefix');
$prod_api = Config::get('prod_api_url');

$file_id = isset($argv[1]) ? (int)$argv[1] : 0;

if(empty($file_id)) {
    echo "---- Must have a file id as the param! \n";
    exit;
}

echo "#####################################\n";
echo date('Y-m-d H:i:s') . ' - ' . "Start loop photos .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo "#####################################\n";

$num = 0;

// Get the row by id
$query = 'SELECT * FROM '. $pre . 'files where id='.$file_id;

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        echo date('Y-m-d H:i:s') . ' - ' . ($num+1) . " - processing id=" . $row['id'] .', '. $row['title'] . " \n";

        // Get physical file cound, 
        // exclude ., .., thumbnail.jpg, non-jpg files
        $physical_path = buildPhysicalPath($row);
        $files = scandir($physical_path);
        //$num_files = count($files)-3; // exclude . & .. & thumbnail
        $num_images = 0;
        $phy_images = [];
        foreach ($files as $f) {
            if($f != '.' && $f != '..' && $f != 'thumbnail.jpg') {
                $extension = pathinfo($physical_path. '/' .$f, PATHINFO_EXTENSION);
                if($extension == 'jpg') {
                    $phy_images[] = $f;
                    $num_images++;
                }
            }
        }

        echo date('Y-m-d H:i:s') . '----- physical image cound = ' . $num_images . "\n";

        // Rename all images by 000 -> 999 number file name with a postfix to avoid override
        $i = 1;
        $new_file_name_arr = [];
        foreach ($phy_images as $f) {
            $postfix = substr(md5(microtime()),rand(0,26),5);
            $new_file_name = sprintf('%03d',$i) . '-'.$postfix.'.jpg';
            echo date('Y-m-d H:i:s') .  '----- change '.$f." to ".$new_file_name;
            $res = rename($physical_path.'/'.$f, $physical_path.'/'.$new_file_name);
            echo $res ? " 1 \n" : " 0 \n";
            $new_file_name_arr[] = $new_file_name;
            $i++;
        }


        // Update the row in the database
        echo date('Y-m-d H:i:s') . "----- Update db row ...... \n";
        $query = 'update '. $pre . 'files set filename="'.implode(',', $new_file_name_arr).'",saved_locally=5  where id='.$row['id'];
        DB::$dbInstance->getRows($query);
        //echo $query; 

        // Build fileObj, then call api to update prod db too
        $fileObj = [
            'source' => $row['source'],
            'source_url' => $row['source_url'],
            'title' => $row['title'],
            'images' => $new_file_name_arr,
            'thumbnail' => 1,
            'tags' => $row['tags'],
        ];
        echo date('Y-m-d H:i:s') . '----- sync this to prod ...... ';
        $res2 = curl_call($prod_api.'?ac=save_file_data', 'post', array('obj'=>json_encode($fileObj)));
        echo $res2 . "\n";

        exit;
        
        //$num++;
    }
}