<?php
require_once '../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

###################### Define variables ################

$prod_api = Config::get('prod_api_url');
$site_name = Config::get('theme');

$existed_files = 0;
$total_parsed_urls = 0;

###################### End of define variables ################


// Sync to prod files table
echo date('Y-m-d H:i:s') . ' - ' . "Start to sync new files to prod...\n";
$max_file_id_local = File::getMaxFileId();
$prod_max_id_url = $prod_api . '?ac=get_max_file_id';
$max_file_id_prod = curl_call($prod_max_id_url);
echo date('Y-m-d H:i:s') . ' - ' . "Local max file id = $max_file_id_local, prod max file id = $max_file_id_prod\n";
$i = 0;
$success = 0;
$failed = 0;
if($max_file_id_prod < $max_file_id_local) {
    $sql = 'select * from '.Config::get('db_table_prefix').'files where id > ' . $max_file_id_prod;
    $res = DB::$dbInstance->getRows($sql);
    foreach ($res as $fileObj) {
        $i++;
        $fileObj['images'] = explode(',', $fileObj['filename']);
        $res2 = curl_call($prod_api.'?ac=save_file_data', 'post', array('obj'=>json_encode($fileObj)));
        $res2 == '1' ? $success++ : $failed++;
        $result = $res2?'1':'0';

        echo date('Y-m-d H:i:s') . ' - ' . "$i - sync to prod: ".$fileObj['source_url']." -- $result\n";
    }
}


