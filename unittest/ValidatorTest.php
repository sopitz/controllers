<?php
require_once "PHPUnit/Autoload.php";
require_once "../Validator.php";
require_once "../DbConnector.php";
/**
 * @desc unittests for Validator.php
 * @author sopitz
 * @version 0.0.1
 */
class ValidatorTest extends PHPUnit_Framework_TestCase {
	protected $validator;
	protected $array = array();

	protected $email = "simon@opitzfamily.de";
	protected $tel = "03512053140";
	protected $url = "http://google.de";
	protected $date = "23.02.1992";
	protected $requiredtext = "text";
	protected $number = "123";
	protected $street = "Zschierener Str. 14";
	
	
	public function testIsValidtrue() {
		$array = array();
		array_push($array, array("email", "pemail", $this->email, "false"));
		array_push($array, array("tel", "ptel", $this->tel, "false"));
		array_push($array, array("url", "purl", $this->url, "false"));
		array_push($array, array("datetime", "pdatetime", $this->date, "false"));
		array_push($array, array("text", "ptext", $this->requiredtext, "true"));
		array_push($array, array("number", "pnumber", $this->number, "false"));
		array_push($array, array("street", "pemail", $this->street, "false"));
		
		$this->validator->isValid(json_encode($array));
		$expected = array();
		$actual = $this->validator->getErrors();
		$this->assertEquals($expected, $actual);
	}
	
	public function testCheckEmail() {
		$expected = true;
		$actual = $this->validator->checkEmail($this->email);
		$this->assertEquals($expected, $actual);
	}
	
	public function testCheckPhone() {
		$expected = true;
		$actual = $this->validator->checkPhone($this->tel);
		$this->assertEquals($expected, $actual);
	}
	
	public function testCheckUrl() {
		$expected = true;
		$actual = $this->validator->checkUrl($this->url);
		$this->assertEquals($expected, $actual);
	}
	
	public function testCheckDate() {
		$expected = true;
		$actual = $this->validator->checkDate($this->date);
		$this->assertEquals($expected, $actual);
	}
	
	public function testCheckNumber() {
		$expected = true;
		$actual = $this->validator->checkNumber($this->number);
		$this->assertEquals($expected, $actual);
	}
	
	public function testCheckStreet() {
		$expected = true;
		$actual = $this->validator->checkStreet($this->street);
		$this->assertEquals($expected, $actual);
	}
	
	protected function setUp() {
		$this->validator = new Validator();
	}
	
	protected function tearDown() {
	}
}