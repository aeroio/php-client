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

	public function testPutPublicity() {
		$reflector = new ReflectionMethod('Request', 'put');

		$this->assertThat(
			true,
			$this->equalTo($reflector->isPublic())
		);
	}

	public function testBuildHttpQueryWithArray() {
		$request = new Request();

		$params = array(array('name' => 'Google', 'description' => 'Search engine'));
		$expected = 'name=Google&description=Search+engine';

		$result = $request->buildHttpQuery($params);

		$this->assertEquals($expected, $result);
	}

	public function testBuildHttpQueryWithMixedParams() {
		$request = new Request();

		$params = array(1, array('name' => 'Google', 'description' => 'Search engine'));
		$expected = 'name=Google&description=Search+engine';

		$result = $request->buildHttpQuery($params);

		$this->assertEquals($expected, $result);
	}


	public function testBuildHttpQueryWithNumericParams() {
		$request = new Request();

		$params = array(1);
		$expected = null;

		$result = $request->buildHttpQuery($params);

		$this->assertEquals($expected, $result);
	}

	public function testSetAndGetHeader() {
		$request = new Request();

		$expected = 'header';
		$request->setHeader($expected);
		$result = $request->getHeader();

		$this->assertEquals($expected, $result);
	}

	public function testSetAndGetContent() {
		$request = new Request();

		$expected = 'content';
		$request->setContent($expected);
		$result = $request->getContent();

		$this->assertEquals($expected, $result);
	}
	
	public function testSetAndGetMethod() {
		$request = new Request();

		$actual = 'method';
		$request->setMethod($actual);
		$result = $request->getMethod();
		$expected = 'METHOD';

		$this->assertEquals($expected, $result);
	}

	public function testBuildContext() {
		$request = new Request();

		$data = array(
			'method' => 'POST',
			'header' => "Connection: close\r\n",
			'content' => "name=Google"
		);

		$expected = 'resource';
		$req = $request->buildContext($data);
		$result = gettype($req);

		$this->assertEquals($expected, $result);
	}
}
?>
