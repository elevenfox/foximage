<?php
require'../bootstrap.inc.php';

set_time_limit(0);
ini_set('memory_limit','2048M');
ini_set('display_errors', 1);
error_reporting(E_ERROR);


###################### Define variables ################


/*
---- Clean up junk file ids in tag_file, kkc3, yfx tables ----
DELETE FROM kkc3 WHERE id IN (SELECT a.id FROM kkc3 AS a LEFT JOIN `jw_files` b ON a.file_id=b.id WHERE b.id is null)

DELETE FROM yfx WHERE id IN (SELECT a.id FROM yfx AS a LEFT JOIN `jw_files` b ON a.file_id=b.id WHERE b.id is null)

DELETE FROM jw_tag_file WHERE file_id IN (SELECT a.file_id FROM jw_tag_file AS a LEFT JOIN `jw_files` b ON a.file_id=b.id WHERE b.id is null)
*/

$sql = "DELETE FROM kkc3 WHERE id IN (SELECT a.id FROM kkc3 AS a LEFT JOIN `jw_files` b ON a.file_id=b.id WHERE b.id is null)";
DB::$dbInstance->query($sql);

$sql = "DELETE FROM yfx WHERE id IN (SELECT a.id FROM yfx AS a LEFT JOIN `jw_files` b ON a.file_id=b.id WHERE b.id is null)";
DB::$dbInstance->query($sql);

$sql = "DELETE FROM jw_tag_file WHERE file_id IN (SELECT a.file_id FROM jw_tag_file AS a LEFT JOIN `jw_files` b ON a.file_id=b.id WHERE b.id is null)";
DB::$dbInstance->query($sql);