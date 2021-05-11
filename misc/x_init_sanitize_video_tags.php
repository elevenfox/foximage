<?php

require'../bootstrap.inc';


set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ERROR);

$pre = Config::get('db_table_prefix');

echo date('Y-m-d H:i:s') . ' - ' . " Start sanitizing ... \n\n";
$start_time = time();

// read from videos
$total = Video::getAllVideoscount();
$itemsPerBatch = 1000;
$batches = ceil($total / $itemsPerBatch);
$x = 1;
for($i=1; $i <= $batches; $i++) {
    $videos = Video::getVideos($i, $itemsPerBatch);
    foreach ($videos as $video) {

        echo date('Y-m-d H:i:s') . ' - ' . $x . " Processing for: ".$video['id']." ... \n";

        // loop, get tags
        $tags = empty(trim($video['tags'])) ? [] : explode(',', $video['tags']);

        // sanitizing
        $tags = Video::handle_tag_array($tags);

        // apply new tags
        $tagsStr = implode(',', $tags);
        $video['tags'] = $tagsStr;

        // save video
        $res = Video::save((object)$video);

        if(empty($res)) {
            echo date('Y-m-d H:i:s') . ' - ' . " ----------------- failed  \n";
        }
        else {
            echo date('Y-m-d H:i:s') . ' - ' . " ----------------- success  \n";
        }

        $x++;
    }
}

$end_time = time();
$minutes = ceil(($end_time - $start_time) / 60);

echo "Total time: $minutes minutes \n\n";


