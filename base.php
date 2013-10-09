<?php 

require 'controllers/BaseController.php';
class Base extends BaseController{
	static $appname = "JesusLive";
	static $environment = "development";
	static $db_config = array("host" => "localhost", "user" => "root", "pw" => "", "db_name" => "tms");
	static $baseurl = "http://localhost/tms/";
	static $baseurl_filesys = "/Applications/XAMPP/htdocs/JESUSlive/tms/";
	
	public function __construct() {
		$settings = parse_ini_file("app.ini");
		// todo
	}
}


function customErrorHandler($errorcode, $errormessage, $errorfile, $errorline){
	$base = new Base();
	$base->customErrorHandler($errorcode, $errormessage, $errorfile, $errorline);
	return $base;
}

date_default_timezone_set('Europe/Berlin');
$base = set_error_handler("customErrorHandler");

?>