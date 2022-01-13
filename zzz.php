<?php
//echo phpinfo(); exit;

require_once './bootstrap.inc';

//import('parser/xchina');
//$res = xchina::parse_html('https://xchina.co/photo/id-61054fc7ab92e/1.html');
//$res = xchina::parse_html('https://www.tuzac.com/');


// $img = 'https://t1.xiublog.com:85/gallery/27999/37677/003.jpg';
// $result = curl_call($img, 'get', null, ['timeout' => 15, 'referrer'=>'https://www.fnvshen.com/']);
// if(!empty($result)) {
//     echo '<img width="500" src="data:image/jpeg;base64,'. base64_encode($result).'">';
// }
// else {
//     echo date('Y-m-d H:i:s') . " --------- \033[31m failed to download: " . $img . "\033[39m \n"; 
// }


// import('parser/fnvshen');
// $res = fnvshen::parse_html('https://www.fnvshen.com/g/37677');

// ZDebug::my_print($res);

$query = 'SELECT * FROM jw_files where source="fnvshen" limit 1';
$res = DB::$dbInstance->getRows($query);
if(count($res) >0) {
    foreach ($res as $row) {
        $physical_path = buildPhysicalPath($row);
        var_dump($physical_path);
    }
}

exit;

//////////////////////////////////////////////////
//import('Baidupan');

//$url = 'https://api.amazon.com/auth/o2/token';
// $res = curl_call($url, 'POST', array(
//     'grant_type' => 'authorization_code',
//     'code' => 'ANBzsjhYZmNCTeAszagk',
//     'client_id' => 'amzn1.application-oa2-client.2578f77971ab45e684923a543b35ec0e',
//     'client_secret' => '9ce60fd67a7508c3c2b92f5910ba2322a2420aee372e9379664dd6ecef2a1c73',
//     'redirect_uri' => 'http://localhost',
// ));


//--- url to get code: http://openapi.baidu.com/oauth/2.0/authorize?response_type=code&client_id=68RLITXDmukTDvCoilKX92S77KNt30iL&scope=basic,netdisk&display=tv&qrcode=1&force_login=1&redirect_uri=https://local.tuzac.com/zzz.php';


// $url = 'https://openapi.baidu.com/oauth/2.0/token';
// $data = [
//     'code' => '8edb74c95e3218d9da5dd87e0eff6be6',
//     'grant_type' => 'authorization_code',
//     'client_id' => '68RLITXDmukTDvCoilKX92S77KNt30iL',
//     'client_secret' => 'mPHfN1nU7MLZqjPWB7fOSCzO60E28QIa',
//     'redirect_uri' => 'https://local.tuzac.com/zzz.php.net/'
// ];
// $res = curl_call($url, 'POST', $data);


//https://openapi.baidu.com/oauth/2.0/token?grant_type=authorization_code&code=1b41607ab6485083cdc577da5915bb5e&client_id=68RLITXDmukTDvCoilKX92S77KNt30iL&client_secret=mPHfN1nU7MLZqjPWB7fOSCzO60E28QIa&redirect_uri=https://local.tuzac.com/zzz.php
//$url = 'https://openapi.baidu.com/oauth/2.0/token?code=grant_type=client_credentials&client_id=68RLITXDmukTDvCoilKX92S77KNt30iL&client_secret=mPHfN1nU7MLZqjPWB7fOSCzO60E28QIa';
//$res = curl_call($url);

// $url = 'https://pan.baidu.com/rest/2.0/xpan/file?method=list&dir=/jw-photos/tujigu/秀人网/秀人网_Angela小热巴《性感OL》上部--No.1167-写真集-58P-&order=time&start=0&limit=10&web=web&folder=0&access_token=121.4956aa6fe60d87202068b9e4139913ae.YgnSgDZJqBXmTFoJhC4uYH2fi1WqYlLvLJ2KRgO.tH98Zg&desc=1';
// $res = curl_call($url);

// $url = 'http://pan.baidu.com/rest/2.0/xpan/multimedia?access_token=121.4956aa6fe60d87202068b9e4139913ae.YgnSgDZJqBXmTFoJhC4uYH2fi1WqYlLvLJ2KRgO.tH98Zg&method=filemetas&fsids=[14051942427175]&thumb=1&dlink=1&extra=1';
// $res = curl_call($url);


// $res = Baidupan::get_file_info(['14051942427175']);
// apiReturnJson($res);


// $res = Baidupan::refresh_token();
// apiReturnJson($res); 


/*--------------working Baidupan ------------------*/
// $list = Baidupan::get_file_list_by_path('/jw-photos/tujigu/秀人网/秀人网_Angela小热巴《性感OL》上部--No.1167-写真集-58P-');
// $fsids = [];
// foreach($list as $f) {
//     //echo $f->path . "<br>\n";
//     //echo $f->fs_id . "<br>\n";
//     $fsids[] = $f->fs_id;
// }
// //echo implode(", ", $fsids);
// //apiReturnJson($list); 
// //exit;

// //$fsids = [874926608700543, 1083967005730622, 449762028592180, 273126744626889, 424027147616087, 678723398381814, 938418761565592, 187619091654833, 540413263267650, 402211222597349, 256857911032854, 14051942427175, 51135963978172, 1015054744687121, 456126168127699, 517314912532875, 52347566022116, 938880812720127, 643192371273101, 229095050767472, 408689852192296, 98900079333267, 397426841810288, 658528418730636, 434809508894725, 289907171218878, 358675534840978, 2471658539906, 241348658766052, 598471490375393, 557943055601095, 371045984929705, 989988306871251, 338268419306833, 225640354082983, 130129468621750, 649366973651047, 1005646098039434, 376144241921314, 255751352255781, 581324274539011, 183878945579912, 617206038069651, 245731629151317, 440960130169060, 96780237195508, 534559049432667, 534548436338332, 633414761552362, 1013550474663746, 432252948306674, 641811559516546, 990745981219681, 493568443923058, 491372092737747, 261205525957914, 1004365675033863, 1032449046063684, 206973947328266];
// $fs_id = $fsids[array_rand($fsids)];
// $fs_id_2 = $fsids[array_rand($fsids)];
// //$fs_id = 449762028592180;
// echo 'fs_id = ' . $fs_id . "<br>\n";
// echo 'fs_id = ' . $fs_id_2 . "<br>\n";
// ZDebug::my_print(Baidupan::get_file_info([$fs_id]));
// ZDebug::my_print(Baidupan::get_file_info([$fs_id_2]));
// echo '<img width=500 src="data:image/jpeg;base64,'. base64_encode(Baidupan::get_photo_content($fs_id)) . '">';
// echo '<img width=500 src="data:image/jpeg;base64,'. base64_encode(Baidupan::get_photo_content($fs_id_2)) . '">';


////////////////////////////////////////////////////////////
/*------------- one drive testing--------------*/
// Get code
// https://login.microsoftonline.com/common/oauth2/v2.0/authorize?client_id=5e103147-910d-4a7c-816b-3e66d05e6296&scope=files.read offline_access&response_type=code&redirect_uri=https://local.tuzac.com/zzz.php

//-- code = M.R3_BAY.d9236c2c-fbac-93cb-bb28-afa6633b5e3a


// // Get access_token and refresh_token
// $code = 'M.R3_BAY.d9236c2c-fbac-93cb-bb28-afa6633b5e3a';
// $url = 'https://login.microsoftonline.com/common/oauth2/v2.0/token';
// $res = curl_call($url, 'post', [
//     'code' => $code,
//     'client_id' => '5e103147-910d-4a7c-816b-3e66d05e6296',
//     'redirect_uri' => 'https://local.tuzac.com/zzz.php',
//     'client_secret' => 'QpywYs_N6-W5QEaWe1fYe1~8BmENGN~StX',
//     'grant_type' => 'authorization_code',
// ]);
// apiReturnJson($res); exit;

// // refresh access_token
//import('Onedrive');
// $res = Onedrive::refresh_token();
// apiReturnJson($res); exit;

// download file
// $path = '/jw-photos/tujigu/秀人网/秀人网_Angela小热巴《性感OL》下部-No.1172-写真集-55P-/10.jpg';
// $result = Onedrive::get_photo_content($path);
// echo '<img width="500" src="data:image/jpeg;base64,'. base64_encode($result).'">';

// $path = '/jw-photos/tujigu/@misty';
// $folders = explode('/', $path);
// error_log('--- folders: ' . implode(' --> ', $folders));
// $res = Onedrive::makeDirectories($folders);
// ZDebug::my_print($res);

// $path = '/tujigu/丽柜/丽柜_Model-桃子《空姐制服捆绑绳艺》-美腿玉足写真图片-62P-/5.jpg';
// $res = Onedrive::upload_photo($path, true);
// ZDebug::my_print($res);


// $path = '/tujigu/DDY\ Pantyhose/DDY-Pantyhose_美昕-amp-amp-张茜茹《公路外拍》高叉舍宾亮丝-NO.009-\ 写真集-58P-';
// $res = Onedrive::list_photos_in_folder($path);
// $num_files = count($res);

// $files = Onedrive::list_photos_in_folder('/' . $relative_path);
// $num_files = count($files);
// echo date('Y-m-d H:i:s') . ' -- found '. $num_files . ' in ' . $path . ' on Onedrive.' . " \n";

//ZDebug::my_print($res);
// exit;


////////////////////////////////////////////////////////////////////////////////////////////////
/*------- Wasabi testing -------*/
// require './class/aws/aws-autoloader.php';
// use Aws\S3\S3Client;
// use Aws\S3\Exception\S3Exception;

// $raw_credentials = array(
//    'credentials' => [
//        'key' => 'EYU1GVUSEFYLJESH9PXR',
//        'secret' => 'h8KdCwErSBkNbjBVWaXzwhyTDzZgDVUeKJ9GfecW'
//    ],
//    'endpoint' => 'https://s3.us-west-1.wasabisys.com', // please refer to service end points for buckets in different regions
//    'region' => 'us-west-1', // please refer to service end points for buckets in different regions
//    'version' => 'latest',
//    'use_path_style_endpoint' => true
// );
// $s3 = S3Client::factory($raw_credentials);

// // Set parameters to be used in CRUD operations
// $bucket = "jw-photos";
// $key = "tujigu/模特联盟/模特联盟_李梓熙《最真实的捆绑、情趣SM》-Vol.003-写真集-47P-/18.jpg";
// try {
//     // read object
//     $res = $s3->getObject([
//         'Bucket' => $bucket,
//         'Key' => $key]
//     );
//     //ZDebug::my_print($res);
//     //echo '<img width="500" src="data:image/jpeg;base64,'. base64_encode($res['body']).'">';
//     header("Content-Type: {$res['ContentType']}");
//     echo $res['Body'];
// } 
// catch (S3Exception $e) {
//     ZDebug::my_print($e->getMessage());
//     //echo '------- ' . $e->getMessage() . PHP_EOL;
// }

// import('Wasabi');
// $w3 = new Wasabi();
// $key = "tujigu/模特联盟/模特联盟_李梓熙《最真实的捆绑、情趣SM》-Vol.003-写真集-47P-/28.jpg";
// $res = $w3->get_photo_content($key);
// //ZDebug::my_print($res); exit;
// if($res !== false) {
//     header("Content-Type: {$res['ContentType']}");
//     echo $res['Body'];
// }
// exit;

// $url = 'https://s3.us-west-1.wasabisys.com/jw-photos/tujigu/模特联盟/模特联盟_李梓熙《最真实的捆绑、情趣SM》-Vol.003-写真集-47P-/9.jpg';
// $options = [ 'headers' => [
//     "Authorization: AWS EYU1GVUSEFYLJESH9PXR:h8KdCwErSBkNbjBVWaXzwhyTDzZgDVUeKJ9GfecW",
//     "x-amz-date: " . gmdate("D, d M Y H:i:s T", time()),
// ] ];
// $res = curl_call($url,'get', null, $options);
// ZDebug::my_print($res);
// echo '<img width="500" src="data:image/jpeg;base64,'. base64_encode($res).'">';



////////////////////////////////////////////////
// B2 test

// $url = 'https://jw-photos-2021.s3.us-west-002.backblazeb2.com/';
// $url = 'https://f002.backblazeb2.com/file/jw-photos-2021/';
// $key = urlencode('tujigu/模特联盟/模特联盟_李梓熙《最真实的捆绑、情趣SM》-Vol.003-写真集-47P-/9.jpg');
// //$key = 'tujigu/模特联盟/模特联盟_李梓熙《最真实的捆绑、情趣SM》-Vol.003-写真集-47P-/9.jpg';
// $url = $url . $key;
// echo $url;
// $file_headers = @get_headers($url);
// ZDebug::my_print($file_headers);

// import('B2');
// $b2 = new B2();
// $key = 'tujigu/模特联盟/模特联盟_李梓熙《最真实的捆绑、情趣SM》-Vol.003-写真集-47P-/thumbnail.jpg';
// $res = $b2->get_photo_content($key);
// // ZDebug::my_print($res); exit;
// // echo '<img width="500" src="data:image/jpeg;base64,'. base64_encode($res['body']).'">';
// if($res !== false) {
//         header("Content-Type: {$res['ContentType']}");
//         echo $res['Body'];
// }

// $pre = Config::get('db_table_prefix');
// $query = 'SELECT * FROM '. $pre . 'files where id = 2231';
// $res = DB::$dbInstance->getRows($query);
// if(count($res) >0) {
//     foreach ($res as $row) {
//         echo date('Y-m-d H:i:s') . ' - ' . ($num+1) . " - processing: id=" . $row['id'] .', '. $row['title'] . " \n";
        
//         $physical_path = buildPhysicalPath($row);
//         $file_root = Config::get('file_root');
//         $relative_path = str_replace($file_root, '', $physical_path);
//         $key = $relative_path . '/thumbnail.jpg';
//         $full_path = $physical_path . '/thumbnail.jpg';
//         //$file_content = file_get_contents($full_path);
//         $res = $b2->upload_photo($key, $full_path);
//         ZDebug::my_print($res);
//     }
// }