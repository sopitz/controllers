<?php
/**
 * @desc <b>DbConnector</b> - ?????.
 * @desc <p>public methods:</p><ul><li>????</li></ul>
 * @author bschoene
 * @todo implement methods, errorhandling
 * @version 0.0.1
 */
class DbConnector {
	public static function create() {
	
		$database = new mysqli(Base::$db_config['host'], Base::$db_config['user'], Base::$db_config['pw'], Base::$db_config['db_name']);
		if (mysqli_connect_errno()) {
			return "error";
		}
		return $database;
	}
}
?>