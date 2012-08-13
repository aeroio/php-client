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

	public function testGetWithTokenAndSid() {
		$request = new Request();

		$auth_token = 'AUTH_TOKEN';
		$sid = 'SID';

		$request->get($auth_token, $sid);

		$expectedMethod = 'GET';
		$expectedHeader = 'Authorization: Basic ' . base64_encode("$auth_token:$sid");

		$this->assertEquals($expectedMethod, $request->getMethod());
		$this->assertEquals($expectedHeader, $request->getHeader());
	}

	public function testPostPublicity() {
		$reflector = new ReflectionMethod('Request', 'post');

		$this->assertThat(
			true,
			$this->equalTo($reflector->isPublic())
		);
	}

	public function testPostWithTokenAndSid() {
		$request = new Request();

		$auth_token = 'AUTH_TOKEN';
		$sid = 'SID';
		$params = array(array('name' => 'Google'));
		$query = $request->buildHttpQuery($params);

		$request->post($auth_token, $sid, $params);

		$expectedMethod = 'POST';
		$expectedHeader = 'Authorization: Basic ' . base64_encode("$auth_token:$sid") .
						  "Connection: close\r\n" .
						  "Content-Length: " . strlen($query) . "\r\n";
		
		$this->assertEquals($expectedMethod, $request->getMethod());
		$this->assertEquals($expectedHeader, $request->getHeader());
		$this->assertEquals($query,  $request->getContent());
	}

	public function testPutPublicity() {
		$reflector = new ReflectionMethod('Request', 'put');

		$this->assertThat(
			true,
			$this->equalTo($reflector->isPublic())
		);
	}

	public function testPutWithTokenAndSid() {
		$request = new Request();

		$auth_token = 'AUTH_TOKEN';
		$sid = 'SID';
		$params = array(array('name' => 'Google'));
		$query = $request->buildHttpQuery($params);

		$request->put($auth_token, $sid, $params);

		$expectedMethod = 'PUT';
		$expectedHeader = 'Authorization: Basic ' . base64_encode("$auth_token:$sid") .
						  "Connection: close\r\n" .
						  "Content-Length: " . strlen($query) . "\r\n";
		
		$this->assertEquals($expectedMethod, $request->getMethod());
		$this->assertEquals($expectedHeader, $request->getHeader());
		$this->assertEquals($query,  $request->getContent());
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
