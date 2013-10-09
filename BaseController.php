<?php
// to be extended by all controllers

include_once 'base.php';
include_once 'BaseInterface.php';
require 'DbConnector.php';

use Monolog\Handler\StreamHandler;
use Monolog\Logger;


abstract class BaseController {
	
	public static $log;
	
	/* ### magic area ### */
	public function __construct() {
		if(!($this->isAuthenticated())) {
			die("You dont have permission to access this script!");
		}
	}
	
	public function __autoload($class) {
		// ausbauen, wenn er es nicht findet, ...
		include $class.".php";
	}
	
	/* ### log area ### */
	static function createLogger() {
		$appname = str_replace(" ", "", Base::$appname);
		$log = new Logger($appname);
		// todo path from base url not from local root
		$log->pushHandler(new StreamHandler('/Applications/XAMPP/htdocs/tms/log/'.$appname.'.log', Logger::INFO));
		return $log;
	}
	
	public static function logWarningWithWarningText($warning) {
		if (!(self::$log instanceof Monolog\Logger)) {
			self::$log = self::createLogger();
		}
		try {
			self::$log->addWarning($warning);
		} catch (Exception $e) {
			die("logging impossible. ".$e);
		}
	}
	
	public static function logErrorWithErrorText($error) {
	if (!(self::$log instanceof Monolog\Logger)) {
			self::$log = self::createLogger();
		}
		try {
			self::$log->addError($error);
		} catch (Exception $e) {
			die("logging impossible. ".$e);
		}
	}
	
	public static function logInfoWithInfoText($info) {
	if (!(self::$log instanceof Monolog\Logger)) {
			self::$log = self::createLogger();
		}
		try {
			self::$log->addInfo($info);
		} catch (Exception $e) {
			die("logging impossible. ".$e);
		}
	}

	/* ### security area ### */
	public function isAuthenticated() {
		// get user session from cookie
		return false;
	}
	
	/* ### error area ### */
	public function customErrorHandler($errorcode, $errormessage, $errorfile, $errorline) {
		switch ($errorcode) {
		case E_USER_ERROR: {
			echo "<b>ERROR</b> [$errorcode] $errormessage<br />\n";
			echo "  Fatal error in file $errorfile at line $errorline";
			echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			exit(1);
			break;
		}
		
		case E_USER_WARNING: {
			echo "<b>WARNING:</b> [$errorcode] $errormessage<br />\n";
			break;
		}
		
		case E_USER_NOTICE: {
			echo "<b>INFO:</b> [$errorcode] $errormessage<br />\n";
			break;
		}
		
		default: {
			echo "Unbekannter Fehlertyp: [$errorcode] $errormessage, in file $errorfile at line $errorline<br />\n";
			break;
		}
	}
	return true;
	}
}