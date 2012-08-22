<?php
require_once 'src/Resource.php';

class AeroResourceTest extends PHPUnit_Framework_TestCase {
	public function testSetAndGetAttributes() {
		$expected = 1;
		$aero = new AeroResource();
		$aero->id = $expected;
		$result = $aero->id;

		$this->assertEquals($expected, $result);
	}

	public function testInitialization() {
		$params = array('id' => 1);
		$expected = $params['id'];

		$aero = new AeroResource($params);
		$result = $aero->id;

		$this->assertEquals($expected, $result);
	}
}
?>
