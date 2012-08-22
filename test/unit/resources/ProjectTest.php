<?php
require_once 'src/resources/Project.php';

class AeroRequestTest extends PHPUnit_Framework_TestCase {
	public function testExtends() {
		$project = new AeroProject();

		$this->assertTrue($project instanceof AeroResource);
	}
}
?>
