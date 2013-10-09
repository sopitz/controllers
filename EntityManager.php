<?php
require '../../base.php';
require_once Base::$baseurl_filesys.'/interfaces/IEntityManager.php';
require_once Base::$baseurl_filesys.'/interfaces/IValidator.php';
require_once 'BaseController.php';
/**
 * @desc <b>EntityManager</b> - write PNV object to DB.
 * @desc <p>public methods:</p><ul><li>getEntitiesListfromProjectShortcut($projectShortcut)</li><li>getEntitiesSettingsfromEntityName($entity)</li><li>createJSClassfromProjectShortcut($projectShortcut)</li></ul>
 * @author sopitz
 * @todo create documentation, finalize implementation, write unit-tests, make external error message i18n
 * @version 0.1.6
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
	
	public function persistPNVData($projectShortcut, $partnerID = null, $partnerObj) {
		$entitiesArray = array();
		$entitiesData = array();
		$currentMaxEntityID = "";
		
		// if ($partnerID == null) { check highest PNV-number and create new one }
		
		try {
			if(!$this->validatePartnerinProject($partnerID, $projectShortcut)) {
				throw new Exception('PartnerIsNotValidForProjectException');
			}
		} catch (Exception $e) {
			// create error system
			die("we might have gotten hacked. You are not allowed to enter this area!");
		}
		$database = DbConnector::create();

		// get all project entities to make sure you only save things that are to be saved within that project
		$entitiesArray = $this->getEntitiesListfromProjectShortcut($projectShortcut);
		
		$query = "SELECT MAX(`entityID`) AS `entityID` FROM `entities`";
		$result = $database->query($query);
		while($row = mysqli_fetch_array($result)) {
			$currentMaxEntityID = (int)$row['entityID'];
		}
		
		// TODO: re-validate input
		$validatorErrors = array();
		try {
			foreach ($partnerObj as $entity => $value) {
				switch($this->getEntitiesSettingsfromEntityName($entity)) {
					// TODO: add all relevant and existing data types
					case 'string':
						if (!IValidator::checkNotEmpty($value)) { // everything is considered a string in php if not empty. so we can only check for not empty
							array_push($validatorErrors, "\"".$value."\" is no valid string. Please enter a valid string.");
						}
						break;
							
					default:
						throw new Exception('NoTypeForEntityValueValidation');
						break;
				}
			}
		} catch (Exception $e) {
			// TODO: add error management
			die("Exception $e says: something went badly wrong. couldnt validate input");
		}
		
		
		// check if former version of object exists
		foreach ($partnerObj as $entity => $value) {
			$currentMaxEntityID = $currentMaxEntityID+1;
			if (in_array($entity, $entitiesArray)) {
				$query = "SELECT * FROM entities WHERE `entityPartnerID` LIKE '$partnerID'";
				$result = $database->query($query);
				if (count(mysqli_fetch_array($result))>0) {
					// row update version
					$query = "UPDATE `entities` SET `version` = 'deprecated' WHERE `entityName` LIKE '$entity' AND `entityPartnerID` LIKE '$partnerID'";
					array_push($entitiesData, $query);
					
				}
				$query = "INSERT INTO `entities` (`dbID`, `entityID`, `entityPartnerID`, `entityName`, `entityValue`, `entityDataType`) VALUES (NULL, '$currentMaxEntityID', '10000001', '$entity', '$value', 'string');";
				array_push($entitiesData, $query);
			} // end if in_array
		} 
		
		$this->runQueries($entitiesData);
//		return $entitiesData; // just for debug purposes
	}
	
	/* TODO: create transaction like behaviour to be able to rollback.
	 * would saving help? we could try and write a "rollback"/"undo" feature per sql-statement
	 */
	private function runQueries($querylist) {
		$database = DbConnector::create();
		foreach ($querylist as $query) {
			$result = $database->query($query);
		}
	}
	
	private function validatePartnerinProject($partnerID, $projectShortcut) {
		$projectArray = array();
		$database = DbConnector::create();
		$query = "SELECT `projectShortcut` FROM partner_has_projects WHERE `partnerID` = $partnerID";
		$result = $database->query($query);
		while($row = mysqli_fetch_array($result)) {
			$projectArray[$row['projectShortcut']] = $row['projectShortcut'];
		}
		if (key_exists($projectShortcut, $projectArray)) {
			$query = "SELECT `projectActive` FROM projects WHERE `projectShortcut` LIKE '$projectArray[$projectShortcut]'";
			$result = $database->query($query);
			while($row = mysqli_fetch_array($result)) {
				if ($row['projectActive']) {
					return true;
				}
			}
		}
		return false;
	}
	
	public function getEntitiesListfromProjectShortcut($projectShortcut) {
		$entitiesArray = array();
		
		$database = DbConnector::create();
		
		$query = "SELECT DISTINCT `entityName` FROM project_has_entities WHERE `projectShortcut` LIKE '$projectShortcut'";
		$result = $database->query($query);
		while($row = mysqli_fetch_array($result)) {
			array_push($entitiesArray, $row['entityName']);
		}
		return (array)$entitiesArray;
	}
	
	public function getEntitiesSettingsfromEntityName($entity) {
		// TODO: switch to xml as its more structured. you have better possibilities to store e.g. options
		$database = DbConnector::create();
		$entitySettings = array();
		
		$query = "SELECT * FROM entityList WHERE `entityItemName` LIKE '$entity'";
		$result = $database->query($query);
		while($row = mysqli_fetch_array($result)) {
			$entitySettings[$entity]['entityItemActive'] = $row['entityItemActive'];
			$entitySettings[$entity]['entityItemRequired'] = $row['entityItemRequired'];
			$entitySettings[$entity]['entityItemType'] = $row['entityItemType'];
		}
		return (array)$entitySettings;
	}
	
	public function createJSClassfromProjectShortcut($projectShortcut) {
		// TODO: switch to xml as its more structured. you have better possibilities to store e.g. options
		$entitiesArray = $this->getEntitiesListfromProjectShortcut($projectShortcut);
		foreach ($entitiesArray as $entity => $value) {
			// TODO: create js string and objects as needed. lets see what angular JS needs or wants
		}
	}
	
	
	
}