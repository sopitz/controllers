<?php
/**
 * @desc <b>Mailer</b> - send and persist Mails.
 * @desc <p>public methods:</p><ul><li>g</li></ul>
 * @author sopitz
 * @todo 
 * @version 0.0.1
 */
class Mailer extends BaseController  {
	
	public $data = array();
	public $errors = array();
	public $errorFeedback = "The following errors occured:<br>";
	
	public function __construct() {
		if (Base::$environment == "development") {
			// load tms.sql from examples folder and run statements
			//print_r($_POST);
		}
	}
	
	private function loadTemplateByTemplateName($templateName, $data) {
		//$file = Base::$baseurl_filesys_tms."email/templates/".$templateName.".php?". $dataString ."";
		$file = Base::$baseurl_filesys_tms."email/templates/".$templateName.".php";
		if (!file_exists($file)) {
			die("you got a problem with your template configs!!");
		}
		include $file;

		$output = ob_get_contents();

		ob_end_clean();
		
		return $output;	
	}
	/**
	* @author rlais
	* @desc   loads template model
	* @param  templateModelName
	* @return simpleXML
	*/
	private function loadTemplateModelByTemplateName($templateModelName) {
		$file = Base::$baseurl_filesys_tms."email/templates/models/mail_model.xml";
		if (!file_exists($file)) {
			die("you got a problem with your templateModel configs!!");
		}
		return simplexml_load_file($file);
	}
	/**
	* @author rlais
	* @desc   validates user input with xml model
	* @param  templateModelName, templateName, data
	* @return true if valid
	*/
	private function validateData($templateModelName, $templateName, $data) {
		$modeldata = $this->loadTemplateModelByTemplateName($templateModelName);
		/* check if model and $data match */
		$validator = new Validator();
		foreach ($modeldata as $model) {
			foreach ($model as $field) {
				$userdata = false;
				/* receive data */
				$userdata = $data[''.$field->getName().''];
				
				if ($field->mandatory == 1 && !($userdata)) {
					// TODO: errormanagement to give back to user
					$this->errorFeedback .= $field->getName()." is mandatory but not set!<br />";
				}
				
				if (!$validator->checkNotEmpty($userdata)) {
					array_push($this->errors, $field->getName()." is not a valid string. It must not be empty.<br />");
				} else {
					array_push($this->data, array($field->getName(), $userdata, $field->type));
				}	
			}
		}
		if(empty($this->errors))
			return true;
		else
			return false;
	}
	/**
	* @author rlais
	* @desc   binds data to text model
	* @param  templateName, data
	* @return data-filled text
	*/
	private function bindDataToText($templateName, $data) {
	/*	foreach($data as $key => $value) {
			${$key} = $value;
		}
	*/
	/*	$dataString = "";
		foreach($data as $key => $value) {
		//	${$key} = $value;
			$dataString .= $key ."=". $value ."&";
		//	echo "<br>K: ". $key ."<br>";
		}
	*/	
		$text = $this->loadTemplateByTemplateName($templateName, $data);
		//$filledText = file_get_contents($text."?".$dataString);
		return $text;
	}
	/**
	* @author rlais
	* @desc   sends mail
	* @param  templateName, data
	* @return data-filled text
	*/
	public function send($templateModelName, $templateName, $data) {
		if($this->validateData($templateModelName, $templateName, $data)) {
			$text = $this->bindDataToText($templateName, $data);
			
		
			
		
			$to = $data['recipient_email'];
			$subject = ucfirst($data['type_of_email']);
			$message = $text;
			$anhang = $data['attachments'];
			
			
			$absender = $data['sender_name'];
			$absender_mail = $data['sender_email'];
			$reply = $data['reply_to'];
			
			$mime_boundary = "-----=" . md5(uniqid(mt_rand(), 1));
			
			$header  ="From:".$absender."<".$absender_mail.">\n";
			$header .= "Reply-To: ".$reply."\n";
			
			$header.= "MIME-Version: 1.0\r\n";
			$header.= "Content-Type: multipart/mixed;" . "\r\n";
			$header.= " boundary=\"".$mime_boundary."\"\r\n";
			
			$content = "This is a multi-part message in MIME format.\r\n\r\n";
			$content.= "--".$mime_boundary."\r\n";
			$content.= "Content-Type: text/html; charset=\"utf-8\"\r\n";
			$content.= "Content-Transfer-Encoding: 8bit\r\n\r\n";
			$content.= $message;
			
			
			
			
		
			$attachments = explode(",", $data['attachments']);			
			
			$content .= "\n";	
			
			foreach($attachments as $file) {
				$filename = split('/', $file);
				$numSplits = count($filename) -1;
				$filename = $filename[$numSplits];
				$data = chunk_split(base64_encode(implode("",file($file))));
				$content.= "--".$mime_boundary."\r\n";
				$content.= "Content-Disposition: attachment;\r\n";
				$content.= "\tfilename=\"".$filename."\";\r\n";
				$content.= "Content-Length: .".filesize($file).";\r\n";
				$content.= "Content-Type: ".filetype($file)."; name=\"".$filename."\"\r\n";
				$content.= "Content-Transfer-Encoding: base64\r\n\r\n";
				$content.= $data."\r\n";
			}
			$content .= "--".$mime_boundary."--";
			
			
			
			
			if(mail($to, $subject, $content, $header))
				echo "Mail sent succesfully!";
		
		
			/* add mail to db */
	 		//$database = DbConnector::create();
	 		//$query = "SELECT DISTINCT `entityName` FROM project_has_entities WHERE `projectShortcut` LIKE '$projectShortcut'";
	 		//$result = $database->query($query);
				/* bundle attachements and store them into blob */
				/* store subject */
				/* store text */
			/* send mail */
		}
		else {
			echo "<br><br>". $this->errorFeedback;
		}
	}
}