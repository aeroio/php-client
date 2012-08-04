<?php
require_once 'app/Request.php';

class RequestTest extends PHPUnit_Framework_TestCase {
	public function testGetPublicity() {
		$reflector = new ReflectionMethod('Request', 'get');

		$this->assertThat(
			true,
			$this->equalTo($reflector->isPublic())
		);
	}

	public function testPostPublicity() {
		$reflector = new ReflectionMethod('Request', 'post');

		$this->assertThat(
			true,
			$this->equalTo($reflector->isPublic())
		);
	}
}
?>
