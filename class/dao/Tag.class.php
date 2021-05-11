<?php

/*
 * Class to operate folder table
 * @author: Elevenfox
 */

Class Tag {

    protected static $table_tag_video;
    protected static $table_tags;
    protected static $table_videos;

    private static function setTables() {
        self::$table_tag_video = Config::get('db_table_prefix') . 'tag_video';
        self::$table_tags = Config::get('db_table_prefix') . 'tags';
        self::$table_videos = Config::get('db_table_prefix') . 'videos';
    }

    public static function getVideosByTag($tagName, $page=1, $limit=20) {
        self::setTables();

        $tagName = DB::sanitizeInput($tagName);

        $cacheKey = THEME . '_videos_of_' . $tagName . '_' . $page . '_' . $limit;
        if(APCU && !isAdmin()) {
            $res = apcu_fetch($cacheKey);
            if(!empty($res)) {
                return $res;
            }
        }

        $limit = ($page - 1) * $limit . ',' . $limit;

        $where = "WHERE term_name = '$tagName'";

        $query = "SELECT v.* FROM ".self::$table_tag_video." tv join ".self::$table_videos." v on tv.video_id=v.id $where order by video_id desc limit " . $limit;
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            if(APCU && !isAdmin()) {
                apcu_store($cacheKey, $res, 600);
            }

            return $res;
        }
        else {
            error_log('Failed to get videos by tag: ' . $tagName);
            return false;
        }
    }

    public static function getVideosByTagCount($tagName) {
        self::setTables();

        $tagName = DB::sanitizeInput($tagName);

        $where = "WHERE term_name = '$tagName'";

        $query = "SELECT count(*) as total FROM ".self::$table_tag_video." $where";
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            return $res[0]['total'];
        }
        else {
            return 0;
        }
    }

    public static function getAllTags($page=1, $limit=120, $sort='asc') {
        self::setTables();

        $cacheKey = THEME . '_all_tags_' . $page . '_' . $limit . '_' . $sort;
        if(APCU && !isAdmin()) {
            $res = apcu_fetch($cacheKey);
            if(!empty($res)) {
                return $res;
            }
        }

        $limit = ($page - 1) * $limit . ',' . $limit;
        $query = "select * from ".self::$table_tags." where vid > 5 order by name " . $sort . ' limit ' . $limit;
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

    public static function getAllTagsCount() {
        self::setTables();

        $query = "select count(*) as total from ".self::$table_tags . "  where vid > 5";
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            return $res[0]['total'];
        }
        else {
            return 0;
        }
    }

    public static function upsertTag($tagName) {
        self::setTables();

        $tagName = DB::sanitizeInput($tagName);
        $res = DB::$dbInstance->getRows("select * from ".self::$table_tags." where name='". $tagName ."'");
        if($res && count($res) > 0) {
            $res = DB::$dbInstance->query("update ".self::$table_tags." set `vid`=`vid`+1 where name='" . $tagName . "' ");
            if($res) {
                $res = DB::$dbInstance->getRows("select * from ".self::$table_tags." where name='". $tagName ."'");
                if($res && count($res) > 0) {
                    return $res[0];
                }
            }
            return $res;
        }
        else {
            $res = DB::$dbInstance->query("insert into ".self::$table_tags." set `vid`=1, `name`= '" . $tagName . "' ");
            if($res) {
                $res = DB::$dbInstance->getRows("select * from ".self::$table_tags." where name='". $tagName ."'");
                if($res && count($res) > 0) {
                    return $res[0];
                }
            }
            return $res;
        }
    }

    public static function upsertVideoTag($tid, $tagName, $video_id, $video_md5_id) {
        self::setTables();

        $tagName = DB::sanitizeInput($tagName);
        $res = DB::$dbInstance->getRows("select * from ".self::$table_tag_video." where term_name='". $tagName ."' and video_md5_id='" . $video_md5_id . "' ");
        if($res && count($res) > 0) {
            return $res[0];
        }
        else {
            $res = DB::$dbInstance->query("insert into ".self::$table_tag_video." set 
                    `tid`=" . $tid . ", 
                    `term_name`= '" . $tagName . "',
                    video_id = ". $video_id . ",
                    video_md5_id = '" . $video_md5_id . "'
            ");

            return $res;
        }
    }

    public static function deleteVideoTagsByVideoMd5Id($videoMd5Id) {
        self::setTables();

        $videoMd5Id = DB::sanitizeInput($videoMd5Id);
        $sql = "delete from " . self::$table_tag_video . " where video_md5_id='" . $videoMd5Id . "'";
        return DB::$dbInstance->query($sql);
    }

    public static function getTagsFromTagVideoByVideoMd5($videoMd5Id) {
        self::setTables();

        $tags = [];
        $query = "select tid, term_name from " . self::$table_tag_video . " where video_md5_id ='" . $videoMd5Id . "'";
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            $tags = $res;
        }
        return $tags;
    }

    public static function decreaseTagVidCount($tid) {
        self::setTables();

        $res = DB::$dbInstance->getRows("select * from ".self::$table_tags." where tid='". $tid ."'");
        if($res && count($res) > 0) {
            if(!empty($res[0]['vid']) && $res[0]['vid'] == 1) {
                $sql = "delete from " . self::$table_tags . " where tid='" . $tid . "'";
                DB::$dbInstance->query($sql);
            }
            else {
                DB::$dbInstance->query("update ".self::$table_tags." set `vid`=`vid`-1 where tid='" . $tid . "' ");
            }
        }
    }
}