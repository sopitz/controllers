<?php
/**
 * @desc <b>PDFGen</b> - ?????.
 * @desc <p>public methods:</p><ul><li>????</li></ul>
 * @author sopitz
 * @todo implement methods
 * @version 0.0.1
 */
require_once 'BaseController.php';
require 'lib/pdfcrowd.php';
class Slider extends BaseController {

	/**
	 * @see PDFGen
	 */
	public function __construct($template, $templatedata) {
		if(!($this->isAuthenticated())) {
			die("You dont have permission to access this script!");
		}
		switch($template) {
				
			case "agreement": {
				if ($this->validateTemplatedata($template, $templatedata)) {
					try
					{
						$client = new Pdfcrowd("sopitz", "f7bc17f9c71f27c3323c89aa557d950b");
						$pdf = $client->convertURI('http://h2210809.stratoserver.net/registration/ressources/template.agreement.php?name=Simon&nachname=Opitz&geschlecht=m&vname=Georg&vnachname=Opitz');
						file_put_contents("test2.pdf", $pdf);
					}
					catch(PdfcrowdException $why)
					{
						//echo "Pdfcrowd Error: " . $why;
					}
				}
			}
				
		}
		
		$to = "simon@opitzfamily.de";
		$subject = "test mit att";
		$message ="message body";
		$anhang = array();
		$anhang["name"] = "agreement.pdf";
		$anhang["size"] = filesize('test2.pdf');
		$anhang["type"] = filetype('test2.pdf');
		$anhang["data"] = implode("",file('test2.pdf'));
		
		
		$absender = "Mein Name";
		$absender_mail = "ich@domain";
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
		
		//$anhang ist ein Mehrdimensionals Array
		//$anhang enthält mehrere Dateien
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

	}

	private function validateTemplatedata($template, $templatedata) {
		/*
		 * path = string
		 * vars = array
		 */
		return true;
	}

	public function isAuthenticated() {
		return true;
	}

	public function __autoload($class) {

	}



}
?>
