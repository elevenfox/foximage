<?php
require_once '../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$sources = get_supported_sources();

###################### Define variables ################

$url = empty($_REQUEST['url']) ? '' : $_REQUEST['url'];

$max_urls_per_source = isset($argv[1]) ? (int)$argv[1] : null;
$max_urls_per_source = empty($max_urls_per_source) ? 500 : $max_urls_per_source;

$prod_api = Config::get('prod_api_url');
$site_name = Config::get('theme');
$default_start_page = 1;
$existed_files = 0;
$total_parsed_urls = 0;

###################### End of define variables ################



###################### Define functions ################
function file_db_exist($url) {
	$res = File::getFileBySourceUrl($url);

	if(!$res) {
		$res = File::getIgnoredFileBySourceUrl($url);
	}

	return !empty($res);
}


###################### end of define functions ################


?>

<div style="max-width: 1200px; margin: auto; padding: 10px">

<div style="font-weight: bold; padding: 10px 0">Import Album by URL:</div>
<form method="get" style="width: 100%">
    <input type="text" name="url" value="<?=$url?>" placeholder="url" required style="width: 100%">
    <button style="margin: 20px 0; padding: 8px 30px">Go</button>
</form>

<?php

if(!empty($url)) {

    if(!file_db_exist($url)) {
        echo '<pre>';
        // Call api to parse url and save
        $api_server = Config::get('api_server');
        $imv_url = $api_server . '?ac=import_file&url=' . urlencode($url);
        echo date('Y-m-d H:i:s') . ' - ' . "calling: $imv_url \n";
        $res = json_decode(curl_call($imv_url));
        echo date('Y-m-d H:i:s') . ' - ' . "---- status: ".$res->status.", msg: ".$res->msg." \n\n";

        // Sync to prod files table
        // echo date('Y-m-d H:i:s') . ' - ' . "Start to sync new files to prod...\n";
        // $max_file_id_local = File::getMaxFileId();
        // $max_file_id_prod = curl_call($prod_api . '?ac=get_max_file_id');
        // echo date('Y-m-d H:i:s') . ' - ' . "Local max file id = $max_file_id_local, prod max file id = $max_file_id_prod\n";
        // $i = 0;
        // $success = 0;
        // $failed = 0;
        // if($max_file_id_prod < $max_file_id_local) {
        //     $sql = 'select * from '.Config::get('db_table_prefix').'files where id > ' . $max_file_id_prod;
        //     $res = DB::$dbInstance->getRows($sql);
        //     foreach ($res as $fileObj) {
        //         $i++;
        //         $fileObj['images'] = explode(',', $fileObj['filename']);
        //         $res2 = curl_call($prod_api.'?ac=save_file_data', 'post', array('obj'=>json_encode($fileObj)));
        //         $res2 == '1' ? $success++ : $failed++;
        //         $result = $res2?'1':'0';

        //         echo date('Y-m-d H:i:s') . ' - ' . "$i - sync to prod: ".$fileObj['source_url']." -- $result\n";
        //     }
        // }
        
        echo '</pre>';
    }
}
?>

</div>




