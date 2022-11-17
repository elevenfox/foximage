<?php
/**
 * Sqlite3 数据库驱动
 * @author Eric Hu
 * @time 2022-11-05
 * @version 1.0
 */
class foxSqlite3  extends SQLite3 {	
	/**
	 * 初使化连接
	 * 
	 * @param string $dbname 数据库名
	 * @return void 
	 */
	public function __construct($dbname = null) {
		$dbname = empty($dbname) ? Config::get('db_main_dbname') : $dbname;
		$dbname = $dbname . '.sqlite';
		$this->open($dbname);
	}
		
	/**
	 * 查询所有数据
	 * 
	 * @param string $sql SQL语句
	 * @param string $asKey 用做键值的字段名
	 * @return array 查询结果 
	 */
	public function getRows($sql, $asKey = null) {
		try {
			$query  = $this->query($sql);
			$res = array();
			while($row = $query->fetchArray(SQLITE3_ASSOC)) {
				if ($asKey) {
					$res[$row[$asKey]] = $row;
				} else {
					$res[] = $row;
				}
			}
			return $res;
		}
		catch (Exception $e) {
			var_dump($sql);
			var_dump($e->getMessage());
			exit;
		}
	}		

}