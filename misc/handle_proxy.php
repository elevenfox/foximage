<?php

$url = 'http://192.168.1.22:8899/api/v1/proxies?limit=360&countries=US,RU,BR,BG,CZ,BY,ID,FR,CA,IT,UA';
$available_ports = [80, 81, 8080, 8081, 22225, 3128];

$api_server = 'http://api.pornabcd.com:3000';
//$prod = 'http://dev.pabcd.com';
//$api_server = 'http://localhost:3000';


$result = curl_call($url);
$all_proxies = json_decode($result)->proxies;


$to_save = [];
foreach ($all_proxies as $proxy) {
    if(in_array($proxy->port, $available_ports)) {
        $to_save[] = array('ip' => $proxy->ip, 'port' => $proxy->port, 'https' => $proxy->is_https);
    }
}


$res = curl_call($api_server.'/api/save_proxy/', 'post', array('obj'=>json_encode($to_save)));
if($res) {
    echo date('Y-m-d H:i:s') . ' - ' . "Success to api_server! " . $res . "\n";
}
else {
    echo date('Y-m-d H:i:s') . ' - ' . "Failed to sync proxy pool to api_server. \n";
    @mail("elevenfox11@gmail.com","Handle Proxy error!", "Failed to sync proxy pool to api_server.");
}


function curl_call($url, $method='get', $data=null) {
    $postData = $data;
    if(!empty($data) && is_array($data)) {
        $postData = http_build_query($data);
    }
    $ch = curl_init(); // 启动一个CURL会话
    curl_setopt($ch, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

    if($method == 'post') {
        curl_setopt($ch, CURLOPT_POST, strlen($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    }

    $result = curl_exec($ch); // 执行操作

    if ($result == NULL) {
        echo date('Y-m-d H:i:s') . ' - ' . 'CURL error: ' . curl_errno($ch) . " – " . curl_error($ch) . "\n";
    }
    curl_close($ch); // 关闭CURL会话

    return $result;
}