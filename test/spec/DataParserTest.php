<?php
require_once 'app/DataParser.php';

class DataParserTest extends PHPUnit_Framework_TestCase {
	public function testExecutePublicity() {
		$reflector = new ReflectionMethod('DataParser', 'execute');

		$this->assertThat(
			true,
			$this->equalTo($reflector->isPublic())
		);
	}
}
?>
