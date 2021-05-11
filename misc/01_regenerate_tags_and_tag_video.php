<?php

require'../bootstrap.inc';


set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ERROR);

$pre = Config::get('db_table_prefix');

echo date('Y-m-d H:i:s') . ' - ' . " Start regenerating ... \n\n";
$start_time = time();

// truncate tags and tag_video
DB::$dbInstance->query('truncate table ' . $pre . 'tags');
DB::$dbInstance->query('truncate table ' . $pre . 'tag_video');

// read from videos
$total = Video::getAllVideoscount();
$itemsPerBatch = 1000;
$batches = ceil($total / $itemsPerBatch);
$x = 1;
for($i=1; $i <= $batches; $i++) {
    $videos = Video::getVideos($i, $itemsPerBatch);
    foreach ($videos as $video) {
        echo date('Y-m-d H:i:s') . ' - ' . $x . " Processing for: ".$video['id']." ... \n";

        // calling video::save will update video with clean tags also save to tags and tag_video
        $res = Video::save((object)$video);

        $result = empty($res) ? 'failed' : 'success';
        echo date('Y-m-d H:i:s') . ' - ' . " ----------------- $result  \n";

        $x++;
    }
}


$end_time = time();
$minutes = ceil(($end_time - $start_time) / 60);

echo "Total time: $minutes minutes \n\n";




