<?php
// Format folder name to 花漾-vol.123 format
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
        $origin_full_path = $folder_full_path.'/'.$folder_name;
        echo "folder_name: $folder_name \n";
        $folder_name = str_replace('VOL.', 'Vol.', $folder_name);
        $folder_name = str_replace('Vo.', 'Vol.', $folder_name);
        $folder_name = str_replace('NO.', 'No.', $folder_name);


        // handle huayang folders
        // if(!str_starts_with($folder_name, '花漾_-Vol.')) {
        //     $vol_arr = find_between($folder_name, '-Vol.', '-');
        //     $vol_str = '-Vol.' . $vol_arr[0] . '-';
        //     $folder_name = str_replace($vol_str, '', $folder_name);
        //     $folder_name = str_replace('花漾_', '花漾_'.$vol_str, $folder_name);

        //     echo "New    name: $folder_name \n\n";

        //     $new_full_path = $folder_full_path . '/' . $folder_name;

        //     echo "rename($origin_full_path, $new_full_path)\n";
        //     rename($origin_full_path, $new_full_path);
        // }
        if(str_starts_with($folder_name, 'HuaYang花漾')) {
            $folder_name = str_replace('---', '-', $folder_name);
            $folder_name = str_replace('--', '-', $folder_name);
            $folder_name = str_replace('-写真集', '', $folder_name);
            $folder_name = str_replace('P-', 'P', $folder_name);

            $tmp_arr = explode('-', $folder_name);
            if(strpos($tmp_arr[count($tmp_arr) - 1], 'P') !== false) {
                unset($tmp_arr[count($tmp_arr) - 1]);
            }
            $folder_name = implode('-', $tmp_arr);
            //echo $tmp_arr[count($tmp_arr) - 1] . "\n";

            echo "New    name: $folder_name \n";
            $new_full_path = $folder_full_path . '/' . $folder_name;
            
            
            echo "rename($origin_full_path, $new_full_path)\n\n";
            rename($origin_full_path, $new_full_path);
        }

   }
}

