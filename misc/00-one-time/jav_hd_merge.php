<?php

function readDirs($path){
    $path = str_replace('//', '/', $path);
    $basename = basename($path);
  $dirHandle = opendir($path);
  while($item = readdir($dirHandle)) {
    $newPath = $path."/".$item;
    if(is_dir($newPath) && $item != '.' && $item != '..') {
       echo "Found Folder $newPath \n";
       readDirs($newPath);
    }
    elseif($item != '.' && $item != '..') {
        //echo  $basename . "\n";
        $newFullName = sprintf('%02d',$basename).'-'.$item;
        // echo  $newPath . "\n";
        //echo '-- Found File '. $item . "\n";
        // echo $newFullName . "\n";
        echo "copy $newPath to $newFullName \n";
        copy($newPath, './'.$newFullName);
    }
  }
}

$path =  "./";
echo "$path \n";

readDirs($path);