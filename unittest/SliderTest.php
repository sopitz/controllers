<?php
require_once "PHPUnit/Autoload.php";
require_once "../Slider.php";
require_once "../DbConnector.php";
/**
 * @desc unittests for Upload.php
 * @author sopitz
 * @version 0.0.1
 */
class SliderTest extends PHPUnit_Framework_TestCase {
	protected $slider;
	protected $imgList;
	protected $sumfiles = 4;
	protected $testdir = "testdir";
	protected $connection = "";
	
	public function testSortImagesTrue() {
		$expected = true;
		$actual = $this->slider->sortImages($this->imgList);
		$this->assertEquals($expected, $actual);
	}
	
	public function testSortImagesFalse() {
		$expected = false;
		$actual = $this->slider->sortImages("myImage");
		$this->assertEquals($expected, $actual);
	}
	
	public function testAddImageTrue() {
		$expected = true;
		$actual = $this->slider->addImage("myImage.jpg");
		$this->assertEquals($expected, $actual);
	}
	
	public function testAddImageFalse() {
		$expected = false;
		$actual = $this->slider->addImage($this->imgList);
		$this->assertEquals($expected, $actual);
	}
	
	public function testgetFileList() {
		$ex_array = array();
		$counter = 1;
		while ($counter <= $this->sumfiles) {
			array_push($ex_array, "testFile".$counter.".jpg");
			$counter++;
		}
		$expected = $ex_array;
		$actual = $this->slider->getFileList();
		$this->assertEquals($expected, $actual);
	}
	
	public function testGenSlider() {
		$counter = 0;
		$ex_string = "";
		$files = array();
		while ($counter <= $this->sumfiles) {
			$file = "picture".$counter.".jpg";
			array_push($files, $file);
			$ex_string .= '<li><img src="'.$this->testdir.'/'.$file.'" title="" alt="" /></li>';
			$counter++;
		}
		
		$expected = $ex_string;
		$this->slider->files = $files;
		$actual = $this->slider->genSlider();
		$this->assertEquals($expected, $actual);
	}
	
	
	protected function setUp() {
		$this->imgList = array('picture0.jpg', 'picture1.jpg', 'picture2.jpg');
		$this->slider = new Slider("../../../lib/img/slider");
		$this->slider->path = $this->testdir;
		mkdir($this->testdir, 0700);
		$counter = 1;
		while ($counter <= $this->sumfiles) {
			$ourFileName = $this->testdir."/testFile".$counter.".jpg";
			$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
			fclose($ourFileHandle);
			$counter++;
		}
		
		$this->connection = DbConnector::create();
		
		
	}
	
	protected function tearDown() {
		unset($this->slider);
		unset($this->imgList);
		system('rm -rf ' . escapeshellarg($this->testdir), $retval);
	}
}
