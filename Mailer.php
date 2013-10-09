<?php
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
		
		
		$to = "simon@opitzfamily.de";
		$subject = "test mit att";
		$message ="message body";
		$anhang = array();
		$anhang["name"] = "agreement.pdf";
		$anhang["size"] = filesize('/var/www/registration/test2.pdf');
		$anhang["type"] = filetype('/var/www/registration/test2.pdf');
		$anhang["data"] = implode("",file('/var/www/registration/test2.pdf'));
		
		
		$absender = "Mein Name";
		$absender_mail = Base::$mailfrom;
		$reply = "antwort@adresse";
		
		$mime_boundary = "-----=" . md5(uniqid(mt_rand(), 1));
		
		$header  ="From:".$absender."<".$absender_mail.">\n";
		$header .= "Reply-To: ".$reply."\n";
		
		$header.= "MIME-Version: 1.0\r\n";
		$header.= "Content-Type: multipart/mixed;\r\n";
		$header.= " boundary=\"".$mime_boundary."\"\r\n";
		
		$content = "This is a multi-part message in MIME format.\r\n\r\n";
		$content.= "--".$mime_boundary."\r\n";
		$content.= "Content-Type: text/html charset=\"iso-8859-1\"\r\n";
		$content.= "Content-Transfer-Encoding: 8bit\r\n\r\n";
		$content.= $message."\r\n";
		
		if(is_array($anhang) AND is_array(current($anhang)))
		{
			foreach($anhang AS $dat)
			{
				$data = chunk_split(base64_encode($dat['data']));
				$content.= "--".$mime_boundary."\r\n";
				$content.= "Content-Disposition: attachment;\r\n";
				$content.= "\tfilename=\"".$dat['name']."\";\r\n";
				$content.= "Content-Length: .".$dat['size'].";\r\n";
				$content.= "Content-Type: ".$dat['type']."; name=\"".$dat['name']."\"\r\n";
				$content.= "Content-Transfer-Encoding: base64\r\n\r\n";
				$content.= $data."\r\n";
			}
			$content .= "--".$mime_boundary."--";
		}
		else //Nur 1 Datei als Anhang
		{
			$data = chunk_split(base64_encode($anhang['data']));
			$content.= "--".$mime_boundary."\r\n";
			$content.= "Content-Disposition: attachment;\r\n";
			$content.= "\tfilename=\"".$anhang['name']."\";\r\n";
			$content.= "Content-Length: .".$dat['size'].";\r\n";
			$content.= "Content-Type: ".$anhang['type']."; name=\"".$anhang['name']."\"\r\n";
			$content.= "Content-Transfer-Encoding: base64\r\n\r\n";
			$content.= $data."\r\n";
		}
		
		
		
		
		mail($to, $subject, $content, $header);
		
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