<?php
require_once '../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ERROR);

// Get theme as the website unique name
$site_name = Config::get('theme');

echo date('Y-m-d H:i:s') . ' - ' . "############################# \n";
echo date('Y-m-d H:i:s') . ' - ' . " Start syncing $site_name ... \n\n";
$start_time = time();

$prod_api_url = Config::get('prod_api_url');
if(empty($prod_api_url)) {
    echo " ---- No prod_api_url defined, exit \n\n";
    exit;
}

$data_zip_file = '/tmp/syncedData.zip';

// Clean /tmp/ old data
echo date('Y-m-d H:i:s') . ' - ' . " -- Cleaning old data files ... \n\n";
exec("rm -rf /tmp/tmp");
exec("rm -f $data_zip_file");

// 1) Call api to download zipped data file for 4 tables
echo date('Y-m-d H:i:s') . ' - ' . " -- Calling api to download zipped data file ... \n";
echo date('Y-m-d H:i:s') . ' - ' . " ---- api url: $prod_api_url?ac=getSyncedData&token= ... \n\n";
$contents = file_get_contents("$prod_api_url?ac=getSyncedData&token=just_to_prevent_others_to_user_asdf1254609");
file_put_contents($data_zip_file, $contents);
// 1a) Doing a backup as DB-AUTO-BACKUP in dev too
$bak_full_path = getenv("HOME") . '/001-db_backup/'. $site_name . '-db-'.date('Y-m-d').'.zip';
echo date('Y-m-d H:i:s') . ' - ' . " -- backup db to $bak_full_path ... \n\n";
copy($data_zip_file, $bak_full_path);


// 2) Unzip file to get 4 sql files
echo date('Y-m-d H:i:s') . ' - ' . " -- Unzip file to get 4 sql files ... \n";
$zip = new ZipArchive;
if ($zip->open($data_zip_file) === TRUE) {
    $zip->extractTo('/tmp/');
    $zip->close();
    echo date('Y-m-d H:i:s') . ' - ' . " ------ ok \n\n";
} else {
    echo date('Y-m-d H:i:s') . ' - ' . " ------ failed \n\n";
}


// 3) mysql command import 4 tables
echo date('Y-m-d H:i:s') . ' - ' . " -- Use mysql command import 4 tables ... \n";
$db_host = Config::get('db_main_host');
$db_user = Config::get('db_main_user');
$db_pass = Config::get('db_main_pass');
$db_name = Config::get('db_main_dbname');

$v_file = '/tmp/tmp/_videos.sql';
$u_file = '/tmp/tmp/_users.sql';
$t_file = '/tmp/tmp/_tags.sql';
$tv_file = '/tmp/tmp/_tag_video.sql';

$mysql = file_exists('/usr/local/bin/mysql') ? '/usr/local/bin/mysql' : null;
$mysql = empty($mysql) && file_exists('/usr/bin/mysql') ? '/usr/bin/mysql' : $mysql;

if(empty($mysql)) {
    echo "mysqldump command not found! \n";
    exit;
}

echo "$mysql -u$db_user -h$db_host -p$db_pass $db_name < $v_file 2>&1 \n";
exec("$mysql -u$db_user -h$db_host -p$db_pass $db_name < $v_file 2>&1", $output, $return_var);
echo json_encode($output) . "\n";
echo json_encode($return_var, 1);
exec("$mysql -u$db_user -h$db_host -p$db_pass $db_name < $u_file 2>&1", $output, $return_var);
echo json_encode($output) . "\n";
exec("$mysql -u$db_user -h$db_host -p$db_pass $db_name < $t_file 2>&1", $output, $return_var);
echo json_encode($output) . "\n";
exec("$mysql -u$db_user -h$db_host -p$db_pass $db_name < $tv_file 2>&1", $output, $return_var);
echo json_encode($output) . "\n\n";


$end_time = time();
$minutes = ceil(($end_time - $start_time) / 60);

echo "Total time: $minutes minutes \n\n";

mail("elevenfox11@gmail.com","$site_name sync to product", "Total time: $minutes minutes");


