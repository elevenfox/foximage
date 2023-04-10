<?php
// 重命名文件夹用tujigu的名字，copy desc 和 tags，重命名thumbnail
if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

function find_between($str, $startDelimiter, $endDelimiter) {
    $contents = array();
    $startDelimiterLength = strlen($startDelimiter);
    $endDelimiterLength = strlen($endDelimiter);
    $startFrom = $contentStart = $contentEnd = 0;
    while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
      $contentStart += $startDelimiterLength;
      $contentEnd = strpos($str, $endDelimiter, $contentStart);
      if (false === $contentEnd) {
        break;
      }
      $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
      $startFrom = $contentEnd + $endDelimiterLength;
    }
  
    return $contents;
}

$folder_full_path = isset($argv[1]) ? $argv[1] : null;

if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}

$scan = scandir($folder_full_path);
foreach($scan as $folder_name) {
   if (is_dir("$folder_full_path/$folder_name") && $folder_name!='.' && $folder_name!='..') {
        $the_full_path = "$folder_full_path/$folder_name";
        echo "------------------------- \n";
        echo "-- Current folder: $folder_name \n";
        // Get cuurent folder vol number
        $l_folder_name = strtolower($folder_name);
        $v_arr = explode(' ',$l_folder_name);
        $vol = $v_arr[1];

        // Go to origin path to get folder name with the same vol num
        $origin = getOriginFolderByVol($vol);
        echo print_r($origin,1) . "\n";
        
        if(!empty($origin)) {
            // copy desc.txt and tags.txt from origin folder
            echo "copy " . $origin['full_path'] . "/desc.txt " . $the_full_path . "/\n";
            copy($origin['full_path'] . "/desc.txt", $the_full_path . "/desc.txt");
            // copy($origin['full_path'] . "/tags.txt", $the_full_path . "/tags.txt");

            // Gen new tags
            $tags_str = file_get_contents($origin['full_path'] . "/tags.txt");
            $tags = explode(',', $tags_str);
            if(! in_array('BoLoli', $tags)) {
                $tags[] = 'BoLoli';
            }
            if(! in_array( $origin['model'], $tags ) ) {
                $tags[] = $origin['model'];
            }
            $new_tags_str = implode(',', $tags);
            echo " new tags: $new_tags_str \n";
            // create tags.txt
            echo "file_put_contents($the_full_path/tags.txt, $new_tags_str) \n";
            file_put_contents($the_full_path.'/tags.txt', $new_tags_str);

            // create a new empty dl.txt in current folder
            echo "file_put_contents($the_full_path/dl.txt, '') \n";
            file_put_contents($the_full_path.'/dl.txt', '');

            // If no thumbnail.jpg, rename last image to thumbnail.jpg
            // $scan2 = scandir($the_full_path);
            // $images = [];
            // foreach($scan2 as $file) {
            //     $origin_file_full = $the_full_path . '/' . $file;
            //     if ( is_file($origin_file_full) && @is_array(getimagesize($origin_file_full)) ) {
            //         $images[] = $file;
            //     }
            // }
            // echo 'rename('. $the_full_path . '/' . $images[0] . ', ' . $the_full_path . '/thumbnail.jpg' .  "\n\n";
            // rename($the_full_path . '/' . $images[count($images) - 1] , $the_full_path . '/thumbnail.jpg');    

            // rename current folder to the origin folder name
            echo "rename $the_full_path to $folder_full_path/BoLoli波萝社-". $vol. '-'. $origin['main'] . "\n\n";
            rename($the_full_path, $folder_full_path . '/BoLoli波萝社-' . $vol. '-'. $origin['main']);
        }
   }
}



function getOriginFolderByVol($vol_num) {
    $origin_folders = '/mnt/nas/jw-photos/tujigu/波萝社/';
    $scan = scandir($origin_folders);
    $folder_info = [];
    foreach($scan as $folder_name) {
        if (is_dir("$origin_folders/$folder_name") && $folder_name!='.' && $folder_name!='..') {
            $l_folder_name = strtolower($folder_name);
            if(strpos($l_folder_name, $vol_num) !== false) {
                $l_folder_name = str_replace('---','-',$l_folder_name);
                $l_folder_name = str_replace('《','-',$l_folder_name);
                $l_folder_name = str_replace('》','',$l_folder_name);
                $folder_info['name'] = $l_folder_name;
                $folder_info['full_path'] = $origin_folders  . '/' . $folder_name;

                $tt = find_between($l_folder_name, '_', '-');
                $folder_info['model'] = $tt[0];

                $yy = find_between($l_folder_name, '波萝社_', '-bol');
                $folder_info['main'] = $yy[0];
            }
        }
    }

    return $folder_info;
}