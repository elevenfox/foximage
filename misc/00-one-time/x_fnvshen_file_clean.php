<?php
require_once '../../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$pre = Config::get('db_table_prefix');
$prod_api = Config::get('prod_api_url');

$file_id = isset($argv[1]) ? (int)$argv[1] : 0;


echo "#####################################\n";
echo date('Y-m-d H:i:s') . ' - ' . "Start loop photos .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo "#####################################\n";

$num = 0;

// Get all rows which source is fnvshen
$query = 'SELECT * FROM '. $pre . 'files where source="fnvshen" and (saved_locally !=5 or saved_locally is null) order by id';

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        echo date('Y-m-d H:i:s') . ' - ' . ($num+1) . " - processing id=" . $row['id'] .', '. $row['title'] . " \n";

        // Get filename, explode by ","
        $images = explode(',', $row['filename']);
        $image_count_db = count($images);
        
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

        echo date('Y-m-d H:i:s') . '----- image cound db = ' . $image_count_db . "\n";
        echo date('Y-m-d H:i:s') . '----- physical image cound = ' . $num_images . "\n";

        $missing = $image_count_db > $num_images;
        if($missing > 0) {
            echo date('Y-m-d H:i:s') . " -----  \033[31m missing ".$missing." images \033[39m \n";
        }

        // Rename all images by 000 -> 999 number file name with a postfix to avoid override
        $i = 1;
        $new_file_name_arr = [];
        $postfix = time();
        foreach ($phy_images as $f) {
            $new_file_name = sprintf('%03d',$i) . '-'.$postfix.'.jpg';
            echo date('Y-m-d H:i:s') .  '----- change '.$f." to ".$new_file_name;
            $res = rename($physical_path.'/'.$f, $physical_path.'/'.$new_file_name);
            echo $res ? " 1 \n" : " 0 \n";
            $new_file_name_arr[] = $new_file_name;
            $i++;
        }
        // remove postfix
        $i = 1;
        $new_file_name_arr2 = [];
        foreach ($new_file_name_arr as $nf) {
            $new_file_name = sprintf('%03d',$i) . '.jpg';
            echo date('Y-m-d H:i:s') .  '----- change '.$nf." to ".$new_file_name;
            $res = rename($physical_path.'/'.$nf, $physical_path.'/'.$new_file_name);
            echo $res ? " 1 \n" : " 0 \n";
            $new_file_name_arr2[] = $new_file_name;
            $i++;
        }


        // Update the row in the database
        echo date('Y-m-d H:i:s') . "----- Update db row ...... \n";
        $query = 'update '. $pre . 'files set filename="'.implode(',', $new_file_name_arr2).'",saved_locally=5  where id='.$row['id'];
        DB::$dbInstance->getRows($query);
        //echo $query; 

        // Build fileObj, then call api to update prod db too
        $fileObj = [
            'source' => $row['source'],
            'source_url' => $row['source_url'],
            'title' => $row['title'],
            'images' => $new_file_name_arr2,
            'thumbnail' => 1,
            'tags' => $row['tags'],
        ];
        echo date('Y-m-d H:i:s') . '----- sync this to prod ...... ';
        $res2 = curl_call($prod_api.'?ac=save_file_data', 'post', array('obj'=>json_encode($fileObj)));
        echo $res2 . "\n";

        exit;
        
        $num++;
    }
}