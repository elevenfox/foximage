<?php

require_once '../../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$pre = Config::get('db_table_prefix');

echo "#####################################\n";
echo date('Y-m-d H:i:s') . ' - ' . "Start re-importing tujigu photos .... \n";
echo date('Y-m-d H:i:s') . ' - ' . "-- on " . Config::get('theme') . " \n";
echo "#####################################\n\n";

// Read from db which source is tujigu and id < 18523
$query = 'SELECT * FROM '. $pre . 'files where source ="tujigu" and filename = ""';

$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {

	$i = 1;
	$success = 0;
	$failed = 0;

    foreach ($res as $row) {
		$source_url = $row['source_url'];
		echo date('Y-m-d H:i:s') . ' - ' . "$i - importing: ".$row['id']." - ".$row['source_url']." \n";

		// call imv to import page again with the source_url
		$api_server = Config::get('api_server');
		$imv_url = $api_server . '?ac=import_file&url=' . urlencode($source_url);
		echo date('Y-m-d H:i:s') . ' - ' . "calling: $imv_url \n";
		$res = json_decode(curl_call($imv_url));
		echo date('Y-m-d H:i:s') . ' - ' . "---- status: ".$res->status.", msg: ".$res->msg." \n\n";
		if($res->status) {
			$success++;
		}
		else {
			$failed++;
		}
		$i++;
	}

	echo date('Y-m-d H:i:s') . ' - ' . "Total have " . ($i-1) . " files, successfully imported $success, failed $failed \n\n";	
}
else {
	echo date('Y-m-d H:i:s') . ' - ' . "DB query failed! \n\n";	
}





