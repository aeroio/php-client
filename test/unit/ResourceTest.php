<?php
require_once 'src/Resource.php';

class AeroResourceTest extends PHPUnit_Framework_TestCase {
	public function testSetAndGetAttributes() {
		$expected = 1;
		$aero = new Test_Resource();
		$aero->id = $expected;
		$result = $aero->id;

		$this->assertEquals($expected, $result);
	}

	public function testInitialization() {
		$params = array('id' => 1);
		$expected = $params['id'];

		$aero = new Test_Resource($params);
		$result = $aero->id;

		$this->assertEquals($expected, $result);
	}

	public function testUrlGetWithId() {
		$aero = new Test_Resource();

		$id = 1;
		$aero->id = $id;
		$expected = "/api/v1/resource/$id.json";

		$result = $aero->url();

		$this->assertEquals($expected, $result);
	}

	public function testUrlGetAll() {
		$aero = new Test_Resource();

		$expected = "/api/v1/resource.json";

		$result = $aero->url();

		$this->assertEquals($expected, $result);
	}
}

class Test_Resource extends Aero_Resource {
	public $id;
}
?>
