<?php

require_once '../bootstrap.inc';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);


$from = isset($argv[1]) ? (int)$argv[1] : 1;
$to = isset($argv[2]) ? (int)$argv[2] : 1000;
$php_api = isset($argv[3]) ? $argv[3] : Config::get('prod_api_url');

//$prod_api = 'https://www.pornabcd.com/api'; // temporary override

$table_videos = Config::get('db_table_prefix') . 'videos';

$s = time();
echo "#### Start processing ... \n\n";
echo "start querying from table: " . $table_videos . "\n\n";

$query = "SELECT * FROM ". $table_videos . " WHERE (source = 'pornhub' or source = 'redtube') and id > " . $from . " and id < " . $to;

echo "Query: " . $query . "\n\n";

$rows = DB::$dbInstance->getRows($query);

$i = 1;
$j = 0;
foreach ($rows as $row) {
    echo $i . ' - (' . $row['id'] . '): ' . $row['title'] . ' (' . $row['source_url'] . ")\n";

    $html = strtolower(curl_call($row['source_url']));
    $res = strpos($html, 'video has been flagged for verification');
    $res2 = strpos($html, 'error page not found');
    $res3 = strpos($html, 'video has been removed');
    $res4 = strpos($html, 'video was deleted');
    if($res !== false || $res2 !== false || $res3 !== false || $res4 !== false) {
        $j++;

        if($res !== false) $msg = 'no-access';
        if($res2 !== false) $msg = '404';
        if($res3 !== false) $msg = 'removed';
        if($res3 !== false) $msg = 'deleted';
        echo "-------------- found one $msg! ";

        // Going to delete this video by calling api
        $res = curl_call($php_api . '?ac=delete_video_by_admin_opln35lmz9517sdjf', 'post', [
            'video_md5_id' => $row['source_url_md5'],
            'd_token' => Config::get('db_driver'),
        ]);

        if($res) {
            echo " --- Deleted! \n";
        }
        else {
            echo " --- Failed! \n";
        }
    }

    $i++;
}

$e = time();
$spend = $e - $s;
echo "\nTotally found $j \n";
echo "Took " . gmdate("H:i:s", $spend) . "\n\n";