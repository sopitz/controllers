<?php
/**
 * @desc <b>Slider</b> - ?????.
 * @desc <p>public methods:</p><ul><li>????</li></ul>
 * @author bschoene
 * @todo implement methods
 * @version 0.0.1
 * Anmerkungen: bei SQL-Statements bitte Platzhalter verwenden und die Variablen doppelt und dreifach validieren (SQL-Injection etc), ansonsten ist der Code echt schšn sauber und aufgerŠumt. GefŠllt mir!
 */
require_once 'BaseController.php';
class Slider extends BaseController {
// 	du musst class-Variablen nicht leer instanzieren. Das ist bei C notwendig, da kein Speichermanagement vorhanden. In OOP-Sprachen hast du das Problem eigentlich meistens nicht. Wenn du sie fŸr sicherheitsrelevate Sachen brauchst, dann instanziere sie mit einem default-Wert, den du spŠter bei if abfragen kannst und wei§t, ob der User nix angegeben hat oder so ;)
	public  $files = "";
// 	private $log = "";
	public  $path = "";
	public  $html = "";
	public  $typ = 'image';
	
	/**
	 * @see Slider.php
	 */
	// public function __construct($newPath, $style = NULL, $html = NULL);
	// new Slider(path, style);
	// new Slider(path, html);
	// new Slider(path, style, html);
	public function __construct($newPath, $html) {
// 		self::logErrorWithErrorText("this is my error text");
// 		self::logWarningWithWarningText("this is my warning text");
// 		self::logInfoWithInfoText("this is my info text");
// 		echo Base::$environment;
		if(!($this->isAuthenticated())) {
			die("You dont have permission to access this script!");
		}
		
		//SetPath
		if(isset($newPath)) {
			$this->path = $newPath;
		}
		
		if(isset($html)) {
			$this->html = $html;
		}
	}
	
	public function isAuthenticated() {
		return true;
	}
	
	public function __autoload($class) {
		
	}
	
	/**
	 * @author bschoene
	 * @desc   gets filename from path
	 * @param  void
	 * @return Array with all entries
	 */
	public function getFileList() {
		$entries = array();
		if ($handle = opendir($this->path)) {
			while (false !== ($entry = readdir($handle))) {
				$path_parts = pathinfo($entry, PATHINFO_EXTENSION);
				if(!($entry === "." || $entry === ".." || $entry === ".DS_Store" || $path_parts['extension'] == "t")) {
					array_push($entries, $entry);
				}
			}
			closedir($handle);
		}
		return $entries;
	}

	
	/**
	 * @author bschoene
	 * @desc   drops & recreates table, inserts new sort of Sliders
	 * @param  Array: images('filename1','filename2')
	 * @return boolean
	 */
	// public function sortImagesWithImageArray($images)
	public function sortImages($images) {
		if (!(is_array($images))) {
			return false;
		}
		$database = DbConnector::create();
		if ($database == "error") {
			return false;
		} else {
		}
		
		$query = "DROP TABLE IF EXISTS slider;";
		$result = $database->query($query);
		if (!$result) {
			return false;
		}
		
		$query = "CREATE TABLE slider (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,`filename` TEXT NOT NULL) ENGINE = MYISAM;";
		$result = $database->query($query);
		
		foreach ($images as $image) {
			$query = "INSERT INTO slider (filename) VALUES ('".$image."');";
			$result = $database->query($query);
		}
		
		if(!($result)) {
			return false;
		}
		return true;
	}
	
	/**
	 * @author bschoene
	 * @desc   adds image to slider / inserts new entry in db
	 * @param  string 'filename1'
	 * @return boolean
	 */
	public function addImage($filename) {
		if (!(is_string($filename))) {
			return false;
		}
		$database = DbConnector::create();
		if ($database == "error") {
			return false;
		} else {
		}
	
		$query = "INSERT INTO slider (filename) VALUES ('".$filename."');";
		$result = $database->query($query);
	
		if(!($result)) {
			return false;
		}
		return true;
	}
	
	/**
	 * @author bschoene
	 * @desc   adds image to slider / inserts new entry in db
	 * @param  string 'filename1'
	 * @return boolean
	 */
	public function delImage($filename) {
		if (!(is_string($filename))) {
			return false;
		}
		$database = DbConnector::create();
		if ($database == "error") {
			return false;
		} else {
		}

		$query = "DELETE FROM slider WHERE filename = '".$filename."';";
		$result = $database->query($query);
		
// 		changed!! includes baseurl now, no problems with includes or stuff anymore. always goes for absolute path
		unlink(Base::$baseurl.$this->path."/".$filename);
	
		if(!($result)) {
			return false;
		}
		return true;
	}
	
	/**
	 * @author bschoene
	 * @desc   gets filenames from DB and puts them in array
	 * @param  void
	 * @return void
	 */
	public function getDataforGenSlider() {
		$database = DbConnector::create();
		if ($database == "error") {
			return false;
		} else {
		}
		
		$query = "SELECT filename FROM slider ORDER BY id ASC";
		$result = $database->query($query);
		
		$files = array();
		while($row = mysqli_fetch_array($result)) {
			array_push($files, $row['filename']);
		}
		return $files;
	}
	
	/**
	 * @author bschoene
	 * @desc   puts filenames in html-tagged string
	 * @param  void
	 * @return string
	 */
	public function genSlider() {
		$this->files = $this->getDataforGenSlider();
		$html = "";
		foreach ($this->files as $file) {
			$html .= str_replace(array("{FILENAME}","{IMAGE_SOURCE}"), array($file, $this->path."/".$file), $this->html);
		}
		return $html;
	}
}

?>
