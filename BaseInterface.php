<?php
// defines which methods NEED to be implemented and at which access level
interface BaseInterface {
	function isAuthenticated();
	static function customErrorHandler($errorcode, $errormessage, $errorfile, $errorline);
	static function logWarningWithWarningText($warning);
	static function logErrorWithErrorText($error);
	static function logInfoWithInfoText($info);
}