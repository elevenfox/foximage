<?php

/*
 * Class to operate folder table
 * @author: Elevenfox
 */


Class Video {

    protected static $table_videos;
    protected static $table_legacy_usrl_alias;

    protected static $table_tag_video;

    private static function setTables() {
        self::$table_videos = Config::get('db_table_prefix') . 'videos';
        self::$table_legacy_usrl_alias = Config::get('db_table_prefix') . 'legacy_url_alias';
        self::$table_tag_video = Config::get('db_table_prefix') . 'tag_video';
    }

    public static function getMaxVideoId() {
        self::setTables();

        $res = DB::$dbInstance->getRows('select max(id) as maxId from ' . self::$table_videos);
        return $res[0]['maxId'];
    }

    public static function deleteByMd5($videoMd5Id) {
        self::setTables();

        $videoMd5Id = DB::sanitizeInput($videoMd5Id);

        // Delete tag_video records, count down tag vid
        $tags = Tag::getTagsFromTagVideoByVideoMd5($videoMd5Id);
        foreach ($tags as $tag) {
            Tag::decreaseTagVidCount($tag['tid']);
        }

        $res = Tag::deleteVideoTagsByVideoMd5Id($videoMd5Id);
        if($res) {
            $sql = "delete from " . self::$table_videos . " where source_url_md5 = '" . $videoMd5Id . "'";
            return DB::$dbInstance->query($sql);
        }
        return false;
    }

    public static function getVideoByID($id) {
        self::setTables();

        $id = (int)DB::sanitizeInput($id);
        $where = "WHERE id = '$id'";

        $query = "SELECT * FROM ".self::$table_videos." $where";
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            return $res[0];
        }
        else {
            error_log('Failed to get video by id: ' . $id);
            return false;
        }
    }

    public static function getVideoBySourceUrl($url) {
        self::setTables();

        //$url = DB::sanitizeInput($url);
        $url = str_replace("'", "\'", $url);
        $query = "SELECT * FROM ".self::$table_videos." WHERE source_url = '$url' ";
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            return $res[0];
        }
        else {
            error_log('Failed to get video by source_url: ' . $url);
            return false;
        }
    }

    public static function getVideoByMd5($md5) {
        self::setTables();

        $md5 = DB::sanitizeInput($md5);
        $query = "SELECT * FROM ".self::$table_videos." WHERE source_url_md5 = '$md5' ";
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            return $res[0];
        }
        else {
            error_log('Failed to get video by source_url md5: ' . $md5);
            return false;
        }
    }

    public static function getVideoByUrlAlias($url) {
        self::setTables();

        $url = DB::sanitizeInput($url);
        $query = "select v.*
                    from ".self::$table_legacy_usrl_alias." a
                    left join ".self::$table_videos." v on v.`id` = a.`video_id`
                    where a.`alias` = 'video/" . $url . "'";

        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            return $res[0];
        }
        else {
            error_log('Failed to get video by url-alias: ' . $url);
            return false;
        }
    }

    public static function getVideos($page=1, $limit=20, $sort='desc') {
        self::setTables();

        $cacheKey = THEME . '_all_videos_' . $page . '_' . $limit . "_" . $sort;
        if(APCU && !isAdmin()) {
            $res = apcu_fetch($cacheKey);
            if(!empty($res)) {
                return $res;
            }
        }

        $limit = ($page - 1) * $limit . ',' . $limit;
        $query = 'select * from '.self::$table_videos.' order by id ' . $sort . ' limit ' . $limit;
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            if(APCU && !isAdmin()) {
                apcu_store($cacheKey, $res, 600);
            }

            return $res;
        }
        else {
            return null;
        }
    }

    public static function getAllVideoscount() {
        self::setTables();

        $query = 'select count(id) as total from ' . self::$table_videos;
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            return $res[0]['total'];
        }
        else {
            return null;
        }
    }


    public static function getVideosByUserName($userName, $page=1, $limit=1000, $sort='desc') {
        self::setTables();
        $userName = DB::sanitizeInput($userName);

        $limit = ($page - 1) * $limit . ',' . $limit;
        $query = 'select * from '.self::$table_videos.' where user_name = \''.$userName.'\' order by id ' . $sort . ' limit ' . $limit;
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            return $res;
        }
        else {
            return null;
        }
    }




    public static function searchVideo($term, $page=1, $limit=20) {
        self::setTables();

        $term = DB::sanitizeInput($term);
        $limit = ($page - 1) * $limit . ',' . $limit;
        $query = "select * from ".self::$table_videos." where title like '%" . $term . "%' limit " . $limit;
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            return $res;
        }
        else {
            return null;
        }
    }

    public static function searchVideoCount($term) {
        self::setTables();

        $term = DB::sanitizeInput($term);
        $query = "select count(*) from ".self::$table_videos." where title like '%" . $term . "%'";
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            return $res;
        }
        else {
            return null;
        }
    }


    public static function getRelatedVideosById($videoId) {
        self::setTables();

        $cacheKey = THEME . '_related_videos_' . $videoId;
        if(APCU && !isAdmin()) {
            $res = apcu_fetch($cacheKey);
            if(!empty($res)) {
                return $res;
            }
        }

        $query = 'select count(id) as total from ' . self::$table_videos;
        $res = DB::$dbInstance->getRows($query);

        $totalVideo = $res[0]['total'];

        $limit = random_int(1, $totalVideo) .',' . 20;
        $query = 'select * from '.self::$table_videos.' order by id desc  limit ' . $limit;
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            if(APCU && !isAdmin()) {
                apcu_store($cacheKey, $res, 600);
            }
            return $res;
        }
        else {
            return null;
        }
    }


    /**
     * Save video to videos table
     *
     * @param $videoObj
     * @return bool
     */
    public static function save($videoObj, $user_name=null) {
        self::setTables();

        if(!self::validation($videoObj)) {
            return false;
        }

        if(is_array($videoObj->tags)) {
            $tag_array = $videoObj->tags;
        }
        else {
            $tag_array = empty(trim($videoObj->tags)) ? [] : explode(',', $videoObj->tags);
        }
        $videoObj->tags = implode(',', self::handle_tag_array($tag_array));

        $video = empty($videoObj->id) ? self::getVideoBySourceUrl($videoObj->source_url) : self::getVideoByID($videoObj->id);
        if(empty($video)) {
            // insert
            try {
                $user_name = empty($user_name) ? User::getRandomUserName() : $user_name;

                $res = DB::$dbInstance->query("insert into ".self::$table_videos." set 
                        `title` = '" . DB::sanitizeInput($videoObj->title) . "',
                        `source` = '". $videoObj->source . "',
                        `source_url` = '". str_replace("'", "\'", $videoObj->source_url) . "',
                        `source_url_md5` = '". md5($videoObj->source_url) . "',
                        `duration` = ".  (int)$videoObj->duration . ",
                        `saved_locally` = 0,
                        `quality_1080p` = '". str_replace("'", "\'", $videoObj->quality_1080p) . "',
                        `quality_720p` = '". str_replace("'", "\'", $videoObj->quality_720p) . "',
                        `quality_480p` = '". str_replace("'", "\'", $videoObj->quality_480p) . "',
                        `quality_360p` = '". str_replace("'", "\'", $videoObj->quality_360p) . "',
                        `quality_240p` = '". str_replace("'", "\'", $videoObj->quality_240p) . "',
                        `thumbnail` = '". str_replace("'", "\'", $videoObj->thumbnail) . "',
                        `gif_preview` = '". str_replace("'", "\'", $videoObj->gif_preview) . "',
                        `tags` = '". str_replace("'", "\'", $videoObj->tags) . "',
                        `created` = '".  date('Y-m-d H:i:s', time()) . "',
                        `user_name` = '" . $user_name . "',
                        `view_count` = 0
                      ");

                if($res) {
                    self::saveVideoTags($videoObj);
                }
                
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }
        else {
            try {
                $sql = "update ".self::$table_videos." set 
                        `title` = '" . DB::sanitizeInput($videoObj->title) . "',
                        `duration` = ".  (int)$videoObj->duration . ",
                        `quality_1080p` = '". str_replace("'", "\'", $videoObj->quality_1080p) . "',
                        `quality_720p` = '". str_replace("'", "\'", $videoObj->quality_720p) . "',
                        `quality_480p` = '". str_replace("'", "\'", $videoObj->quality_480p) . "',
                        `quality_360p` = '". str_replace("'", "\'", $videoObj->quality_360p) . "',
                        `quality_240p` = '". str_replace("'", "\'", $videoObj->quality_240p) . "',
                        `thumbnail` = '". str_replace("'", "\'", $videoObj->thumbnail) . "',
                        `gif_preview` = '". str_replace("'", "\'", $videoObj->gif_preview) . "',
                        `tags` = '". str_replace("'", "\'", $videoObj->tags) . "'
                        where id = " . $video['id'] . "
                      ";
                //echo '-------'.$sql.'--------';
                $res = DB::$dbInstance->query($sql);

                if($res) {
                    self::saveVideoTags($videoObj);
                }

                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }
    }


    public static function updateViewCount($video_md5_id) {
        self::setTables();

        $sql = 'update ' . self::$table_videos . ' set view_count = view_count + 10, modified=modified where source_url_md5 = \'' . $video_md5_id . '\'';
        return DB::$dbInstance->query($sql);
    }

    public static function markForDeleting($source_url) {
        self::setTables();

        $sql = 'update ' . self::$table_videos . ' set saved_locally = -9 where source_url = \'' . $source_url . '\'';
        return DB::$dbInstance->query($sql);
    }

    private static function validation($videoObj) {
        if(empty($videoObj->title) || strstr($videoObj->title, 'gay') !== false ) {
            error_log('Video title cannot be empty and not a gay video');
            return false;
        }
        if(empty($videoObj->source)) {
            error_log('Video source cannot be empty');
            return false;
        }
        if(empty($videoObj->source_url)) {
            error_log('Video source_url cannot be empty');
            return false;
        }
        if(empty($videoObj->duration)) {
            error_log('Video duration cannot be empty');
            return false;
        }
        if( empty($videoObj->quality_1080p) && empty($videoObj->quality_720p)
            && empty($videoObj->quality_480p) && empty($videoObj->quality_360p)
            && empty($videoObj->quality_240p) ) {
            error_log('Video has no source');
            return false;
        }
        return true;
    }


    /**
     * Before save video to video table or node, handle the tags
     *
     * @param $tag_array
     * @return array
     */
    public static function handle_tag_array($tag_array) {
        $default_terms = ['blow job', 'big tits', 'babe', 'fuck'];
        $default_jp_terms = ['日本成人', '美女性感', '肉棒', '鸡吧', '鸡巴', '大肉棒', '大鸡吧', '大鸡巴', '大鸡吧操逼', '大鸡巴操逼', '日小穴', '操屁眼儿', '日逼', '大鸡吧操', '大鸡巴操', '大奶子', '大胸', '美女', '美穴'];

        $tag_array = empty($tag_array) || count($tag_array) == 0 ? [$default_terms[array_rand($default_terms)]] : $tag_array;

        $new_tags = [];
        $jp_term = '';
        $jp_term_exist = false;
        foreach($tag_array as $tag) {
            $tag = cleanStringForUrl($tag, ' ');
            if(!empty($tag)) {
                $new_tags[] = $tag;

                if (strpos($tag, 'japan') !== false || strpos($tag, 'china') !== false || strpos($tag, 'chinese') !== false) {
                    $jp_term = $default_jp_terms[array_rand($default_jp_terms)];
                }
                if (in_array($tag, $default_jp_terms)) {
                    $jp_term_exist = true;
                }
            }
        }
        if(!empty($jp_term) && !$jp_term_exist) {
            $new_tags[] = $jp_term;
        }

        return $new_tags;
    }


    private static function saveVideoTags($videoObj) {
        $video = self::getVideoBySourceUrl($videoObj->source_url);
        if($video) {
            $tags = empty(trim($videoObj->tags)) ? [] : explode(',', $videoObj->tags);
            $tags = self::handle_tag_array($tags);

            foreach ($tags as $tag) {
                $tagObj = Tag::upsertTag($tag);
                Tag::upsertVideoTag($tagObj['tid'], $tagObj['name'], $video['id'], $video['source_url_md5']);
            }
        }
    }

}