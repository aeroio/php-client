<?php
require_once 'src/resources/Project.php';

class AeroRequestTest extends PHPUnit_Framework_TestCase {
	public function testExtends() {
		$project = new Aero_Project();

		$this->assertTrue($project instanceof Aero_Resource);
	}
}
?>
