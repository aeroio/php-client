<?php
require_once 'src/Request.php';

class AeroRequestTest extends PHPUnit_Framework_TestCase {
	public function testInitialization() {
		$params = array('id' => 1);
		$expected = $params['id'];

		$aero = new AeroRequest($params);
		$result = $aero->id;

		$this->assertEquals($expected, $result);
	}
}
?>
