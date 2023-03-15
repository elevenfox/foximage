<?php
// Map ID in databse to folder name
if (!function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

function find_between($str, $startDelimiter, $endDelimiter) {
    $contents = array();
    $startDelimiterLength = strlen($startDelimiter);
    $endDelimiterLength = strlen($endDelimiter);
    $startFrom = $contentStart = $contentEnd = 0;
    while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
      $contentStart += $startDelimiterLength;
      $contentEnd = strpos($str, $endDelimiter, $contentStart);
      if (false === $contentEnd) {
        break;
      }
      $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
      $startFrom = $contentEnd + $endDelimiterLength;
    }
  
    return $contents;
}

$folder_full_path = isset($argv[1]) ? $argv[1] : null;

$content = file_get_contents($folder_full_path);
$lines = explode(PHP_EOL, $content);
$i = 1;
foreach($lines as $l) {
    //echo $i . " -- " . $l . "\n";
    $l = str_replace('VOL', 'Vol', $l);
    $l = str_replace('NO.', 'Vol.', $l);
    $l = str_replace('Vo.', 'Vol.', $l);
    $p_arr = explode(',', $l);
    $t_arr = find_between($l, 'Vol.', ' ');
    echo $t_arr[0] . ', ' . $p_arr[1] . "\n";

    $i++;
}

