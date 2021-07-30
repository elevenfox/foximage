<?php

/*
 * Class to operate folder table
 * @author: Elevenfox
 */

Class Tag {

    protected static $table_tag_file;
    protected static $table_tags;
    protected static $table_files;

    private static function setTables() {
        self::$table_tag_file = Config::get('db_table_prefix') . 'tag_file';
        self::$table_tags = Config::get('db_table_prefix') . 'tags';
        self::$table_files = Config::get('db_table_prefix') . 'files';
    }

    public static function getFilesByTag($tagName, $page=1, $limit=20) {
        self::setTables();

        $tagName = DB::sanitizeInput($tagName);

        $cacheKey = THEME . '_files_of_' . $tagName . '_' . $page . '_' . $limit;
        if(APCU && !isAdmin()) {
            $res = apcu_fetch($cacheKey);
            if(!empty($res)) {
                return $res;
            }
        }

        $limit = ($page - 1) * $limit . ',' . $limit;

        $where = "WHERE term_name = '$tagName'";

        $query = "SELECT v.* FROM ".self::$table_tag_file." tv join ".self::$table_files." v on tv.file_id=v.id $where order by v.rand_id desc limit " . $limit;
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            if(APCU && !isAdmin()) {
                apcu_store($cacheKey, $res, 600);
            }

            return $res;
        }
        else {
            error_log('Failed to get files by tag: ' . $tagName);
            return false;
        }
    }

    public static function getFilesByTagCount($tagName) {
        self::setTables();

        $tagName = DB::sanitizeInput($tagName);

        $where = "WHERE term_name = '$tagName'";

        $query = "SELECT count(*) as total FROM ".self::$table_tag_file." $where";
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            return $res[0]['total'];
        }
        else {
            return 0;
        }
    }

    /**
     * Gett all tags function
     *
     * @param integer $page
     * @param integer $limit
     * @param integer $sort_by 1: alphabic asc, 2: alphabic desc, 3: vid asc, 4: vid desc
     * @return void
     */
    public static function getAllTags($page=1, $limit=120, $sort_by = 1) {
        self::setTables();

        $cacheKey = THEME . '_all_tags_' . $page . '_' . $limit . '_' . $sort_by;
        if(APCU && !isAdmin()) {
            $res = apcu_fetch($cacheKey);
            if(!empty($res)) {
                return $res;
            }
        }

        $limit = ($page - 1) * $limit . ',' . $limit;
        switch($sort_by) {
            case 1:
                $order_by = 'order by convert(name using gbk) collate gbk_chinese_ci asc';
                break;
            case 2:
                $order_by = 'order by convert(name using gbk) collate gbk_chinese_ci desc';
                break;
            case 3:
                $order_by = 'order by vid asc';
                break;
            case 4:
                $order_by = 'order by vid desc';
                break;
            default:  
                $order_by = 'order by convert(name using gbk) collate gbk_chinese_ci asc';
                break;   
        }
        $query = "select * from ".self::$table_tags." where vid > 5 " . $order_by . ' limit ' . $limit;
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

    public static function upsertFileTag($tid, $tagName, $file_id) {
        self::setTables();

        $tagName = DB::sanitizeInput($tagName);
        $res = DB::$dbInstance->getRows("select * from ".self::$table_tag_file." where term_name='". $tagName ."' and file_id='" . $file_id . "' ");
        if($res && count($res) > 0) {
            return $res[0];
        }
        else {
            $res = DB::$dbInstance->query("insert into ".self::$table_tag_file." set 
                    `tid`=" . $tid . ", 
                    `term_name`= '" . $tagName . "',
                    file_id = ". $file_id
            );

            return $res;
        }
    }

    public static function deleteFileTagsByFileId($fileId) {
        self::setTables();

        $fileId = DB::sanitizeInput($fileId);
        $sql = "delete from " . self::$table_tag_file . " where file_id='" . $fileId . "'";
        return DB::$dbInstance->query($sql);
    }

    public static function getTagsFromTagFileByFileId($fileId) {
        self::setTables();

        $tags = [];
        $query = "select tid, term_name from " . self::$table_tag_file . " where file_id ='" . $fileId . "'";
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