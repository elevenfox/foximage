<?php

/*
 * Class to operate folder table
 * @author: Elevenfox
 */


Class File {

    protected static $table_files;
    protected static $table_files_ignored;
    protected static $table_tag_file;

    private static function setTables() {
        self::$table_files = Config::get('db_table_prefix') . 'files';
        self::$table_tag_file = Config::get('db_table_prefix') . 'tag_file';
        self::$table_files_ignored = Config::get('db_table_prefix') . 'files_ignored';
    }

    public static function getMaxFileId() {
        self::setTables();

        $res = DB::$dbInstance->getRows('select max(id) as maxId from ' . self::$table_files);
        return $res[0]['maxId'];
    }

    public static function getFileByID($id) {
        self::setTables();

        $id = (int)DB::sanitizeInput($id);
        $where = "WHERE id = '$id'";

        $query = "SELECT * FROM ".self::$table_files." $where";
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            return $res[0];
        }
        else {
            error_log('Failed to get file by id: ' . $id);
            return false;
        }
    }

    public static function getFileByMd5($md5) {
        self::setTables();

        $md5 = DB::sanitizeInput($md5);
        $query = "SELECT * FROM ".self::$table_files." WHERE source_url_md5 = '$md5' ";
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            return $res[0];
        }
        else {
            error_log('Failed to get file by source_url md5: ' . $md5);
            return false;
        }
    }

    public static function getFileBySourceUrl($url) {
        self::setTables();

        //$url = DB::sanitizeInput($url);
        $url = str_replace("'", "\'", $url);
        $query = "SELECT * FROM ".self::$table_files." WHERE source_url = '$url' ";
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            return $res[0];
        }
        else {
            error_log('Failed to get File by source_url: ' . $url);
            return false;
        }
    }

    public static function getIgnoredFileBySourceUrl($url) {
        self::setTables();

        //$url = DB::sanitizeInput($url);
        $url = str_replace("'", "\'", $url);
        $query = "SELECT * FROM ".self::$table_files_ignored." WHERE source_url = '$url' ";
        $res = DB::$dbInstance->getRows($query);
        if(count($res)) {
            return $res[0];
        }
        else {
            error_log('Failed to get File by source_url: ' . $url);
            return false;
        }
    }

    public static function deleteById($fileId) {
        self::setTables();

        $fileId = DB::sanitizeInput($fileId);

        // Delete tag_video records, count down tag vid
        $tags = Tag::getTagsFromTagFileByFileId($fileId);
        foreach ($tags as $tag) {
            Tag::decreaseTagVidCount($tag['tid']);
        }

        $res = Tag::deleteFileTagsByFileId($fileId);
        if($res) {
            $sql = "delete from " . self::$table_files . " where id = '" . $fileId . "'";
            return DB::$dbInstance->query($sql);
        }
        return false;
    }

    public static function getFiles($page=1, $limit=24, $sort='desc') {
        self::setTables();

        $cacheKey = THEME . '_all_files_' . $page . '_' . $limit . "_" . $sort;
        if(APCU && !isAdmin()) {
            $res = apcu_fetch($cacheKey);
            if(!empty($res)) {
                return $res;
            }
        }

        $limit = ($page - 1) * $limit . ',' . $limit;
        $query = 'select * from '.self::$table_files.' order by id ' . $sort . ' limit ' . $limit;
 
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

    public static function getFilesRand($page=1, $limit=24, $sort='asc') {
        self::setTables();
        
        $cacheKey = THEME . '_all_files_' . $page . '_' . $limit . "_" . $sort;
        if(APCU && !isAdmin()) {
            $res = apcu_fetch($cacheKey);
            if(!empty($res)) {
                return $res;
            }
        }

        $limit = ($page - 1) * $limit . ',' . $limit;
        $query = 'select * from '.self::$table_files.' order by rand_id ' . $sort . ' limit ' . $limit;
 
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

    public static function getAllFilescount() {
        self::setTables();

        $query = 'select count(id) as total from ' . self::$table_files;
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            return $res[0]['total'];
        }
        else {
            return null;
        }
    }


    public static function getFilesByUserName($userName, $page=1, $limit=1000, $sort='desc') {
        self::setTables();
        $userName = DB::sanitizeInput($userName);

        $limit = ($page - 1) * $limit . ',' . $limit;
        $query = 'select * from '.self::$table_files.' where user_name = \''.$userName.'\' order by id ' . $sort . ' limit ' . $limit;
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            return $res;
        }
        else {
            return null;
        }
    }

    public static function searchFile($term, $page=1, $limit=24) {
        self::setTables();

        $term = DB::sanitizeInput($term);
        $limit = ($page - 1) * $limit . ',' . $limit;
        $query = "select * from ".self::$table_files." where title like '%" . $term . "%' limit " . $limit;
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            return $res;
        }
        else {
            return null;
        }
    }

    public static function searchFileCount($term) {
        self::setTables();

        $term = DB::sanitizeInput($term);
        $query = "select count(*) as total from ".self::$table_files." where title like '%" . $term . "%'";
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            return $res[0]['total'];
        }
        else {
            return null;
        }
    }


    public static function getRelatedFilesById($fileId) {
        self::setTables();

        $cacheKey = THEME . '_related_files_' . $fileId;
        $sessionCacheKey = THEME . '_related_files';
        // Use memory cache for non-admin users
        if(APCU && !isAdmin()) {
            $res = apcu_fetch($cacheKey);
            if(!empty($res)) {
                return $res;
            }
        }
        else if (!isAdmin()) {
            // If no memory cache available, at least use sesson to cache for current user
            if(!empty($_SESSION['file_id']) && $_SESSION['file_id'] == $fileId && !empty($_SESSION[$sessionCacheKey])) {
                return $_SESSION[$sessionCacheKey];
            }
        }

        $query = 'select count(id) as total from ' . self::$table_files;
        $res = DB::$dbInstance->getRows($query);

        $totalFile = $res[0]['total'];

        $limit = random_int(1, $totalFile-12) .',' . 12;
        $query = 'select * from '.self::$table_files.' order by rand_id desc  limit ' . $limit;
        $res = DB::$dbInstance->getRows($query);
        if(count($res) >0) {
            if(APCU && !isAdmin()) {
                apcu_store($cacheKey, $res, 600);
            }
            else if (!isAdmin()) {
                $_SESSION['file_id'] = $fileId;
                $_SESSION[$sessionCacheKey] = $res;
            }

            return $res;
        }
        else {
            return null;
        }
    }


    /**
     * Save file to files table
     *
     * @param $fileObj
     * @return bool
     */
    public static function save($fileObj, $user_name=null) {
        self::setTables();

        if(!self::validation($fileObj)) {
            return false;
        }

        if(is_array($fileObj->tags)) {
            $tag_array = $fileObj->tags;
        }
        else {
            $tag_array = empty(trim($fileObj->tags)) ? [] : explode(',', $fileObj->tags);
        }
        $fileObj->tags = implode(',', self::handle_tag_array($tag_array));

        $file = empty($fileObj->id) ? self::getFileBySourceUrl($fileObj->source_url) : self::getFileByID($fileObj->id);
        if(empty($file)) {
            // insert
            try {
                $user_name = empty($user_name) ? User::getRandomUserName() : $user_name;

                $sql = "insert into ".self::$table_files." set 
                    `title` = '" . DB::sanitizeInput($fileObj->title) . "',
                    `source` = '". $fileObj->source . "',
                    `source_url` = '". str_replace("'", "\'", $fileObj->source_url) . "',
                    `source_url_md5` = '". md5(str_replace("'", "\'", $fileObj->source_url)) . "',
                    `description` = '". $fileObj->description . "',
                    `filename` = '". implode(",", $fileObj->images) . "',
                    `thumbnail` = '". str_replace("'", "\'", $fileObj->thumbnail) . "',
                    `tags` = '". str_replace("'", "\'", $fileObj->tags) . "',
                    `created` = '".  date('Y-m-d H:i:s', time()) . "',
                    `user_name` = '" . $user_name . "',
                    `view_count` = 0
                ";

                $res = DB::$dbInstance->query($sql);

                if($res) {
                    self::saveFileTags($fileObj);
                }
                
                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }
        else {
            try {
                $sql = "update ".self::$table_files." set 
                        `title` = '" . DB::sanitizeInput($fileObj->title) . "',
                        `filename` = '". implode(",", $fileObj->images) . "',
                        `thumbnail` = '". str_replace("'", "\'", $fileObj->thumbnail) . "',
                        `tags` = '". str_replace("'", "\'", $fileObj->tags) . "'
                        where id = " . $file['id'] . "
                      ";
                //echo '-------'.$sql.'--------';
                $res = DB::$dbInstance->query($sql);

                if($res) {
                    self::saveFileTags($fileObj);
                }

                return true;
            }
            catch(Exception $e) {
                return false;
            }
        }
    }


    public static function updateViewCount($file_id) {
        self::setTables();

        $sql = 'update ' . self::$table_files . ' set view_count = view_count + 10, modified=modified where id = \'' . $file_id . '\'';
        return DB::$dbInstance->query($sql);
    }

    public static function markForDeleting($source_url) {
        self::setTables();

        $sql = 'update ' . self::$table_files . ' set saved_locally = -9 where source_url = \'' . $source_url . '\'';
        return DB::$dbInstance->query($sql);
    }

    private static function validation($fileObj) {
        if(empty($fileObj->title) || strstr($fileObj->title, 'gay') !== false ) {
            error_log('File title cannot be empty and not a gay file');
            return false;
        }
        if(empty($fileObj->source)) {
            error_log('File source cannot be empty');
            return false;
        }
        if(empty($fileObj->source_url)) {
            error_log('File source_url cannot be empty');
            return false;
        }
        return true;
    }


    /**
     * Before save file to file table or node, handle the tags
     *
     * @param $tag_array
     * @return array
     */
    public static function handle_tag_array($tag_array) {
        $default_terms = ['美胸', '大尺度', '美女写真', '尤物'];
        $default_jp_terms = ['美胸', '大尺度', '美女写真', '尤物'];

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


    private static function saveFileTags($fileObj) {
        $file = self::getFileBySourceUrl($fileObj->source_url);
        if($file) {
            $tags = empty(trim($fileObj->tags)) ? [] : explode(',', $fileObj->tags);
            $tags = self::handle_tag_array($tags);

            foreach ($tags as $tag) {
                $tagObj = Tag::upsertTag($tag);
                Tag::upsertFileTag($tagObj['tid'], $tagObj['name'], $file['id']);
            }
        }
    }

}