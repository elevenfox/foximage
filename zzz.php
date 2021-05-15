<?php

$fp = fopen("/tmp/z_download.lock", "a");

if (flock($fp, LOCK_EX | LOCK_NB)) {  // 进行排它型锁定

    sleep(100000);
    echo 'get the lock, then what?';
} 
else {
    echo "Couldn't get the lock!";
}

exit;

require_once './bootstrap.inc';

//$a = File::deleteByMd5('098d44716ece89cf93079eca4025c705');

ZDebug::my_print($a);