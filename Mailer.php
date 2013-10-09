<?php
require '../../base.php';
require_once Base::$baseurl_filesys.'/interfaces/IEntityManager.php';
require_once Base::$baseurl_filesys.'/interfaces/IValidator.php';
require_once 'BaseController.php';
/**
 * @desc <b>Mailer</b> - send and persist Mails.
 * @desc <p>public methods:</p><ul><li>g</li></ul>
 * @author sopitz
 * @todo 
 * @version 0.0.1
 */
class EntityManager extends BaseController implements IEntityManager  {
	
	/**
	 * @see EntityManager
	 */
	public function __construct() {
		if (Base::$environment == "development") {
			// load tms.sql from examples folder and run statements
		}
	}
	
	private function loadTemplateByTemplateName($templateName) {
		$file = "email/templates/".$templateName.".html";
		if (!file_exists($file)) {
			die("you got a problem with your email configs!!");
		}
		return file_get_contents($file);
	}
	
	private function loadTemplateModelByTemplateName($templateName) {
		$file = "email/templates/models/".$templateName.".xml";
		if (!file_exists($file)) {
			die("you got a problem with your email configs!!");
		}
		return simplexml_load_file($file);
	}
	
	private function validateDate($templateName, $data) {
		$model = $this->loadTemplateModelByTemplateName($templateName);
		/* check if model and $data match */
		
		return true;
	}
	
	private function bindDataToText($templateName, $data) {
		$text = $this->loadTemplateByTemplateName($event);
		/* bind data to text */
	}
	
	public function send($event, $data) {
		if ($this->validateDate($event, $data));
		$text = $this->bindDataToText($event, $data);
		
		
		/* add mail to db */
// 		$database = DbConnector::create();
// 		$query = "SELECT DISTINCT `entityName` FROM project_has_entities WHERE `projectShortcut` LIKE '$projectShortcut'";
// 		$result = $database->query($query);
			/* bundle attachements and store them into blob */
			/* store subject */
			/* store text */
		/* send mail */
	}
}