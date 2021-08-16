<?php

class Baidupan {

    private static $client_id = '68RLITXDmukTDvCoilKX92S77KNt30iL';
    private static $client_secret = 'mPHfN1nU7MLZqjPWB7fOSCzO60E28QIa';
 
    private static $access_token = '121.33816bc272706d2749a06f828d3e0e98.Y7XyfzwFjLRLHe8oecdPfzQa69vEXzzfUwtZtsD.8CXOKQ';
    private static $refresh_token = '122.9fc05ee5fc60e4fc72789a6e455539ec.Y7_qnu5nm-aTy262P_G8VWHxggb4C4yPg4SG92e.3M4d2w';

    private static $pan_api_base_url = 'http://pan.baidu.com/rest/2.0/xpan';
    private static $oauth_api_base_url = 'https://openapi.baidu.com/oauth/2.0/token';


    /**
     * Refresh token
     * 
     * https://openapi.baidu.com/oauth/2.0/token?
     *    grant_type=refresh_token
     *    &refresh_token=REFRESH_TOKEN
     *    &client_id=API_KEY
     *    &client_secret=SECRET_KEY 
     * 
     * @return object $json_object
     */
    public static function refresh_token() {
        $params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => self::$refresh_token,
            'client_id' => self::$client_id,
            'client_secret' => self::$client_secret,
        ];
        $url = self::$oauth_api_base_url . '?' . http_build_query($params, '', '&');
        $res = curl_call($url);

        return json_decode($res);
    }

    public static function upload_photo() {

    }


    /**
     * Get file info by Baidupan path
     * 
     * https://pan.baidu.com/rest/2.0/xpan/file?
     *     access_token=ACCESS_TOKEN
     *     &method=list
     *     &dir=/jw-photos/XXXXXX
     *     &order=time
     *     &start=0
     *     &limit=10
     *     &web=web
     *     &folder=0
     *     &desc=1
     *
     * @param string $path
     * @return object $json_object
     */
    public static function get_file_list_by_path($path) {
        $params = [
            'access_token' => self::$access_token,
            'method' => 'list',
            'dir' => $path,
            'order' => 'time',
            'start' => 0,
            'limit' => 200,
            'web' => 'web',
            'folder' => 0,
            'desc' => 1,
        ];
        $url = self::$pan_api_base_url . '/file?' . http_build_query($params, '', '&');
        $res = curl_call($url);

        return json_decode($res)->list;
    }


    /**
     * Undocumented function
     * 
     * http://pan.baidu.com/rest/2.0/xpan/multimedia?
     *     access_token=ACCESS_TOKEN
     *     &method=filemetas
     *     &fsids=[414244021542671,633507813519281]
     *     &thumb=1
     *     &dlink=1
     *     &extra=1
     *
     * @param array $fs_ids
     * @return object $json_object
     */
    public static function get_file_info(array $fsids) {
        $fsids_string = '[' . implode(',', $fsids). ']';
        $params = [
            'access_token' => self::$access_token,
            'method' => 'filemetas',
            'dlink' => 1,
            'fsids' => $fsids_string,
        ];
        $url = self::$pan_api_base_url . '/multimedia?' . http_build_query($params, '', '&');
        
        $res = curl_call($url);

        return json_decode($res);
    }

    /**
     * Use dlink to get photo content
     *
     * @param string $fsid
     * @return string $res - image binary data
     */
    public static function get_photo_content($fsid) {
        $photo_info = self::get_file_info([$fsid]);

        $dlink = $photo_info->list[0]->dlink;
        
        $ch = curl_init(); // 启动一个CURL会话
        curl_setopt($ch, CURLOPT_URL, $dlink . '&access_token=' . self::$access_token); // 要访问的地址
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_USERAGENT,'pan.baidu.com');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $res = curl_exec($ch); // 执行操作
        
        if ($res == NULL) {
            error_log('CURL error: ' . curl_errno($ch) . " – " . print_r(curl_error($ch),1));
        }
        
        curl_close($ch); // 关闭CURL会话
        
        return $res;
    }
}