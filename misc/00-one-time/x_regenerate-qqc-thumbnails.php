<?php
require_once '../../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$pre = Config::get('db_table_prefix');

$file_id = isset($argv[1]) ? (int)$argv[1] : 0;


echo "#####################################\n";
echo date('Y-m-d H:i:s') . ' - ' . "Start regenerating thumbnials for qqc photos .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo "#####################################\n";

$num = 0;

// Get all rows which source is qqc
$query = 'SELECT * FROM '. $pre . 'files where source = "qqc" and id=3610 order by id limit 3';

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        echo date('Y-m-d H:i:s') . ' - ' . ($num+1) . " - processing: id=" . $row['id'] .', '. $row['title'] . " \n";

        $physical_path = buildPhysicalPath($row);
        
        // Get photo list in the path/folder
        $files = array_diff(scandir($physical_path), array('.', '..'));
        
        if(!in_array('thumbnail.jpg', $files) || filesize($physical_path.'/thumbnail.jpg') < 5000) {

            // Get first portrait photo, if not found, use first landscape photo
            $thumbnail_origin = '';
            foreach ($files as $f) {
                if($f != 'thumbnail.jpg') {
                    list($width, $height, $type) = getimagesize($physical_path.'/'.$f);
                    if($width < $height) {
                        // Portrait photo
                        $thumbnail_origin = $physical_path . '/' . $f;
                        break;
                    }
                }
            }
            if(empty($thumbnail_origin)) {
                $thumbnail_origin = $physical_path . '/' . array_pop(array_reverse($files));
            }
            echo date('Y-m-d H:i:s') . ' ------- ' . " using {$width}x{$height} " . $thumbnail_origin . "\n";
            

            // Crop and create the thumbnail
            $thumbnail_filename = $physical_path . '/' . 'thumbnail.jpg';
            $thumb_width = 250;
            $thumb_height = 375;

            $original_aspect = $width / $height;
            $thumb_aspect = $thumb_width / $thumb_height;

            if ( $original_aspect >= $thumb_aspect )
            {
                // If image is wider than thumbnail (in aspect ratio sense)
                $new_height = $thumb_height;
                $new_width = $width / ($height / $thumb_height);
            }
            else
            {
                // If the thumbnail is wider than the image
                $new_width = $thumb_width;
                $new_height = $height / ($width / $thumb_width);
            }

            $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

            // Resize and crop
            $image = imagecreatefromjpeg($thumbnail_origin);
            imagecopyresampled($thumb,
                            $image,
                            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                            0, 0,
                            $new_width, $new_height,
                            $width, $height);
            imagejpeg($thumb, $thumbnail_filename, 80);
        }
        else {
            echo "------------------------------- Already done. \n";
        }

        $num++;
    }
}



