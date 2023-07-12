<?php

/*
 * Class to operate folder table
 * @author: Elevenfox
 */

Class Tag {

    protected static $table_tag_file;
    protected static $table_tags;
    protected static $table_files;
    protected static $table_base_files;
    protected static $table_tag_view;

    private static function setTables() {
        self::$table_files = Config::get('db_table_prefix') . 'files';
        self::$table_base_files = Config::get('db_table_base_prefix') . 'files';
        self::$table_tag_file = Config::get('db_table_base_prefix') . 'tag_file';
        self::$table_tags = Config::get('db_table_base_prefix') . 'tags';
        self::$table_tag_view = Config::get('db_table_base_prefix') . 'tag_view';
    }


    public static function getFilesByTag($tagName, $page=1, $limit=24, $random=false, $cache=true) {
        self::setTables();

        $tagName = DB::sanitizeInput($tagName);

        $cacheKey = THEME . '_files_of_' . $tagName . '_' . $page . '_' . $limit;
        if(APCU && !isAdmin() && $cache===true) {
            $res = apcu_fetch($cacheKey);
            if(!empty($res)) {
                return $res;
            }
        }

        $limit = ($page - 1) * $limit . ',' . $limit;

        $where = "WHERE term_name = '$tagName'";

        $onFileId = self::$table_files == self::$table_base_files ? 'tv.file_id=v.id' : 'tv.file_id=v.file_id';

        $orderBy = empty($random) ? 'order by v.id desc' : 'ORDER BY RAND()';

        $query = "SELECT v.* FROM ".self::$table_tag_file." tv join ".self::$table_files." v on $onFileId $where $orderBy limit " . $limit;
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
     * @return array $res
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
        $db_driver = Config::get('db_driver');
        switch($sort_by) {
            case 1:
                $order_by = $db_driver == 'foxSqlite3' ? 'order by term asc' : 'order by convert(term using gbk) collate gbk_chinese_ci asc';
                break;
            case 2:
                $order_by = $db_driver == 'foxSqlite3' ? 'order by term desc' : 'order by convert(term using gbk) collate gbk_chinese_ci desc';
                break;
            case 3:
                $order_by = 'order by num asc';
                break;
            case 4:
                $order_by = 'order by num desc';
                break;
            default:  
                $order_by = 'order by convert(term using gbk) collate gbk_chinese_ci asc';
                break;   
        }
        $query = "select * from ".self::$table_tag_view." where num > 5 " . $order_by . ' limit ' . $limit;
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

        $query = "select count(*) as total from ".self::$table_tag_view . "  where num > 5";
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            return $res[0]['total'];
        }
        else {
            return 0;
        }
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

    public static function upsertTag($tagName) {
        self::setTables();

        $tagName = DB::sanitizeInput($tagName);

        // If not exist, insert; otherwise do nothing
        $res = DB::$dbInstance->getRows("select * from ".self::$table_tags." where term='". $tagName ."'");
        if($res && count($res) > 0) {
            return $res[0];
        }
        else {
            $res = DB::$dbInstance->query("insert into ".self::$table_tags." set `term`= '" . $tagName . "' ");
            if($res) {
                $res = DB::$dbInstance->getRows("select * from ".self::$table_tags." where term='". $tagName ."'");
                if($res && count($res) > 0) {
                    return $res[0];
                }
            }
            return $res;
        }
    }

    public static function upsertFileTag($tagName, $file_id) {
        self::setTables();

        $tagName = DB::sanitizeInput($tagName);
        $res = DB::$dbInstance->getRows("select * from ".self::$table_tag_file." where term_name='". $tagName ."' and file_id='" . $file_id . "' ");
        if($res && count($res) > 0) {
            return $res[0];
        }
        else {
            $res = DB::$dbInstance->query("insert into ".self::$table_tag_file." set  
                    `term_name`= '" . $tagName . "',
                    `file_id` = ". $file_id
            );

            return $res;
        }
    }

    public static function deleteFileTagsByFileId($fileId) {
        self::setTables();

        // Delete all tag_file records for this file first
        $fileId = DB::sanitizeInput($fileId);
        $sql = "delete from " . self::$table_tag_file . " where file_id='" . $fileId . "'";
        $res = DB::$dbInstance->query($sql);

        return $res;
    }
}