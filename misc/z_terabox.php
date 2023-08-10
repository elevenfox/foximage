<?php
set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        if(strpos($haystack, $needle) === false) return false;
        else return true;
    }
}

###################### Define variables ################


$folder_full_path = isset($argv[1]) ? $argv[1] : null;
if(empty($folder_full_path)) {
    echo "---- Must have a full folder path as the param! \n";
    exit;
}


###################### End of define variables ################


echo  "#####################################\n";
echo  date('Y-m-d H:i:s') . ' - ' . "Start processing album: $folder_full_path .... \n";
echo  "#####################################\n";


$folder_name = basename($folder_full_path);


// Create dl.txt file for download_url
$tbox_c = '';
$tbox_local_cache = '/tmp/tbox_cache.txt';
$use_local = false;
if(file_exists($tbox_local_cache) ) {
    $f_time = strtotime(trim(shell_exec("date -r $tbox_local_cache")));
    if( $f_time > (time() - 120) ) {
        echo "--use local cache file... \n";
        $use_local = true;
    }
}
if($use_local) {
    $tbox_c = file_get_contents($tbox_local_cache);
}
else {
    echo "--download from google drive... \n";
    $tbox_file = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vTyEtPWDpsqvn4qIEvwmk4__1fTjBTiREPcleN-crVfz4U0PDxBirWx9Vr4gqHlJE9mK5JEyugpbw6S/pub?output=csv';
    $tbox_c = file_get_contents($tbox_file);
    file_put_contents($tbox_local_cache, $tbox_c);
}
$tbox_list = [];
$lines = explode("\n", $tbox_c);
foreach($lines as $l) {
    $l = str_replace(',', ' ', $l);
    $l = preg_replace('!\s+!', ' ', $l);
    $l = str_replace(' ', ',', $l);
    $l_arr = explode(',', $l);
    $k = $l_arr[0];
    $v = empty($l_arr[1])?'':$l_arr[1];
    $tbox_list[$k] = $v;
}
$dl = empty($tbox_list[$folder_name]) ? '' : $tbox_list[$folder_name];
echo date('Y-m-d H:i:s') . ' - ' . "-- download: $dl \n";
file_put_contents($folder_full_path.'/dl.txt', $dl);

echo " \n";