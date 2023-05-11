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


$list_cont = file_get_contents('/home/eric/work/000/XiuRen秀人网-作品列表.txt');

$list = [];
$a = explode("\n", $list_cont);

foreach($a as $l) {
    $bb = strtolower($l);
    $c = find_between($bb, 'no.', ' ');
    if(!empty($c)) {
        $mm = find_between($bb, 'no.', '[');
        if(empty($mm[0])) {
            $m2 = substr($bb, strpos($bb, "no.") + 1); 
            $model = substr($m2, strpos($m2, " ") + 1); 
        }
        else {
            $nn = explode(' ',$mm[0]);
            $model = str_starts_with($nn[1], '2') ? $nn[2] : $nn[1];
        }
        $list[$c[0]] = $model;
    }
}
echo print_r(array_slice($list, 0, 100), 1);

// foreach($list as $k=>$v) {
//     if(empty($v)) {
//         echo "$k \n";
//     }
// }
// exit;

$scan = scandir($folder_full_path);
foreach($scan as $folder_name) {
   if (is_dir("$folder_full_path/$folder_name") && $folder_name!='.' && $folder_name!='..') {
        $origin_full_path = $folder_full_path.'/'.$folder_name;
        echo "folder_name: $folder_name \n";
        $folder_name = str_replace('VOL.', 'Vol.', $folder_name);
        $folder_name = str_replace('Vo.', 'Vol.', $folder_name);
        $folder_name = str_replace('NO.', 'No.', $folder_name);
        $folder_name = strtolower($folder_name);

        if(str_starts_with($folder_name, 'xiuren')) {
            // $folder_name = str_replace('---', '-', $folder_name);
            // $folder_name = str_replace('--', '-', $folder_name);
            // $folder_name = str_replace('-写真集', '', $folder_name);
            // $folder_name = str_replace('P-', 'P', $folder_name);

            $tmp_arr = find_between($folder_name, 'no.', ' ');
            if(!empty($tmp_arr[0]) && (int)$tmp_arr[0] == $tmp_arr[0]) {
                $new_folder_name = '';
                if($tmp_arr[0] < 6000) {
                    if(!empty($list[$tmp_arr[0]])) {
                        $new_folder_name = 'XiuRen-No.' . $tmp_arr[0] .'-'.$list[$tmp_arr[0]];
                    }
                }
                else {
                    if(!empty($list[$tmp_arr[0]])) {
                        $new_folder_name = 'XiuRen秀人网-' . $tmp_arr[0] .'-'.$list[$tmp_arr[0]];
                    }
                }

                if(!empty($new_folder_name)) {
                    echo "New    name: $new_folder_name \n";
                    $new_full_path = $folder_full_path . '/' . $new_folder_name;
                    
                    
                    echo "rename($origin_full_path, $new_full_path)\n\n";
                    rename($origin_full_path, $new_full_path);
                }
            }
        }
   }
}




