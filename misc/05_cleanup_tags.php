<?php

/** After a while, there would be too many taxonomy and will slow down the system
 * This script will clean taxonomy only leave some basic for now.
 * Will implement more complex logic in video.module save_taxonomy method to hanle
 * what taxonomy we will save
 *
 * -- Update: I'll just remove all terms which only have 0 or 1 or 2 nodes for safe
 */

/*
-- query to cleanup junk data in tag_videos (60 seconds to 150 seconds)
delete tv
from `pabcd_tag_video` tv
left join pabcd_videos v on v.id = tv.`video_id`
where v.id is null;

-- query to recalculate videos belong to a tag (10 seconds)
update `pabcd_tags` td
set td.vid=(
	select count(tv.video_id)
	from pabcd_tag_video tv
	where tv.`tid` = td.tid
);


-- cleanup tags table (1 second)
delete from pabcd_tags where vid = 0;

*/


require'../bootstrap.inc';

$pre = Config::get('db_table_prefix');

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ERROR);

echo date('Y-m-d H:i:s') . ' - ' . " Start processing ... \n\n";
$start_time = time();

//$keep_taxonomy = array("Brunette", "Blonde", "Japanese", "Amateur ", "Asian", "Blonde", "Cartoons", "Celebrities", "Cum Shots", "Facial", "French", "German", "Handjobs", "High Definition", "Interracial", "Latina", "Lesbian", "Massage", "Milfs", "Public Sex", "Toys", "Squirting", "Webcam", "Blow Job", "Anal", "Big Tits", "Blowjobs");

// Get all junk taxonmy
//$res = db_query('SELECT * FROM {taxonomy_term_data} WHERE name NOT IN (:termNames)', array(':termNames' => $keep_taxonomy));


// Remove tags having less than 10 videos
$sql = 'select td.*
from '.$pre.'tags td
left join '.$pre.'tag_video tv on tv.tid=td.tid
group by td.tid
having count(tv.video_id) < 20';
$res = DB::$dbInstance->getRows($sql);
$x = 1;
foreach ($res as $term) {

    echo date('Y-m-d H:i:s') . ' - ' . $x . ' - cleaning term name: ' . $term['name'] . " ... \n";

  $sql = 'delete from '.$pre.'tags where tid=' . $term['tid'];
  echo $sql . "\n";
    DB::$dbInstance->query($sql);

    $sql = 'delete from '.$pre.'tag_video where tid=' . $term['tid'];
    echo $sql . "\n";
    DB::$dbInstance->query($sql);

  $x++;
}

// remove tags such like "123 video"
$sql = "select * from ".$pre."tags where name like '%videos%'";
echo $sql . "\n";
$res = DB::$dbInstance->getRows($sql);
foreach ($res as $term) {

    echo date('Y-m-d H:i:s') . ' - ' . $x . ' - cleaning term name: ' . $term['name'] . " ... \n";

    $sql = 'delete from '.$pre.'tags where tid=' . $term['tid'];
    echo $sql . "\n";
    DB::$dbInstance->query($sql);

    $sql = 'delete from '.$pre.'tag_video where tid=' . $term['tid'];
    echo $sql . "\n";
    DB::$dbInstance->query($sql);

    $x++;
}

// remove tags only numbers
$sql = "SELECT * FROM ".$pre."tags WHERE concat('', name * 1) = name;";
echo $sql . "\n";
$res = DB::$dbInstance->getRows($sql);
foreach ($res as $term) {

    echo date('Y-m-d H:i:s') . ' - ' . $x . ' - cleaning term name: ' . $term['name'] . " ... \n";

    $sql = 'delete from '.$pre.'tags where tid=' . $term['tid'];
    echo $sql . "\n";
    DB::$dbInstance->query($sql);

    $sql = 'delete from '.$pre.'tag_video where tid=' . $term['tid'];
    echo $sql . "\n";
    DB::$dbInstance->query($sql);

    $x++;
}


echo "Totally removed " . $x . " tags \n";

$end_time = time();
$minutes = ceil(($end_time - $start_time) / 60);

echo "Total time: $minutes minutes \n\n";
