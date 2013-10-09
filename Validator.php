<?php
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @desc <b>Validator</b> - ?????.
 * @desc <p>public methods:</p><ul><li>????</li></ul>
 * @desc <script type="text/javascript">var form="#myform",button="#senddata",url="form.php";$(document).ready(function(){var a=[];$(button).click(function(){$(form).children().filter(":input").each(function(){a.push([this.type,this.name,this.value,this.required])});$.ajax({type:"POST",url:url,data:{data:JSON.stringify(a)}})})});</script>
 * @author bschoene, sopitz
 * @todo implement methods
 * @version 0.0.1
 */
class Validator {
	
	protected $status = array();
	
	/**
	 * @author sopitz
	 * @desc   validates
	 * @param  json(data)
	 * @return true, fals
	 */
	public function isValid($jsoninput) {
		$data = $this->prepareData(json_decode($jsoninput));
		foreach ($data as $field => $elements) {
			if ($elements['required'] == true) {
				if (!($this->checkNotEmpty($elements['value']))) {
					array_push($this->status, "field ". $field ." required");
				}
			}
			
			switch ($elements['type']) {
				case "email": {
					if (!($this->checkEmail($elements['value']))) {
						array_push($this->status, "field ". $field ." is no valid email adress");
					}
					break;
				}
				
				case "tel": {
					if (!($this->checkPhone($elements['value']))) {
						array_push($this->status, "field ". $field ." is no valid phone number");
					}
					break;
				}
				
				case "url": {
					if (!($this->checkUrl($elements['value']))) {
						array_push($this->status, "field ". $field ." is no valid url");
					}
					break;
				}
				
				case "datetime": {
					if (!($this->checkDate($elements['value']))) {
						array_push($this->status, "field ". $field ." is no valid date");
					}
					break;
				}
				
				case "number": {
					if (!($this->checkNumber($elements['value']))) {
						array_push($this->status, "field ". $field ." is no valid number");
					}
					break;
				}
				
				case "street": {
					if (!($this->checkStreet($elements['value']))) {
						array_push($this->status, "field ". $field ." is no valid street");
					}
					break;
				}
			}
			
		}
	}
	
	/**
	 * @author sopitz
	 * @desc   
	 * @param  
	 * @return 
	 */
	public function prepareData($data) {
		$return_data = array();
		foreach ($data as $array) {
			$return_data[$array[1]] = array("type" => $array[0], "value" => $array[2], "required" => $array[3]);
		}
		return $return_data;
	}
	
	/**
	 * @author sopitz
	 * @desc
	 * @param
	 * @return
	 */
	public function getErrors() {
		return $this->status;
	}
	
	/**
	 * @author bschoene
	 * @desc   checks if entry is empty
	 * @param  entry
	 * @return true is entry isn't empty
	 */
	public function checkNotEmpty($entry) {
		if(empty($entry)) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * @author bschoene
	 * @desc   checks if email is valid
	 * @param  email
	 * @return bool
	 */
	public function checkEmail($email) {
		 if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
		 	list($username,$domain)=explode('@',$email);
		 	if(!checkdnsrr($domain,'MX')) {
		 		return false;
		 	}
		 	return true;
		 }
		 return false;
	}
	
	/**
	 * @author bschoene
	 * @desc   checks if phone is valid
	 * @param  phone
	 * @return bool
	 */
	public function checkPhone($phone) {
		$number = str_replace(array('/','+','-',' ','(',')'), '', $phone);
		if(is_numeric($number)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @author bschoene
	 * @desc   checks if url is valid
	 * @param  url
	 * @return bool
	 */
	public function checkUrl($url) {
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}
	
	/**
	 * @author bschoene
	 * @desc   checks if date is valid
	 * @param  date(day,month,year)
	 * @return bool
	 */
	public function checkDate($date) {
		if(strtotime($date) == false) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * @author bschoene
	 * @desc   checks if number is valid
	 * @param  number
	 * @return bool
	 */
	public function checkNumber($number) {
		if(is_numeric($number)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @author bschoene
	 * @desc   checks if street and number is valid
	 * @param  street, number
	 * @return bool
	 */
	public function checkStreet($street) {
		$array = explode(" ", $street);
		$street_letter = substr($array[0], 0, 1);
		$street_number = substr($array[count($array)-1], 0, 1);
			
		if(ctype_alpha($street_letter) && is_numeric($street_number)) {
			return true;
		} else {
			return false;
		}
	}

}

?>
