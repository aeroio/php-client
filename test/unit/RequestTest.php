<?php
require_once 'src/Request.php';

class AeroRequestTest extends PHPUnit_Framework_TestCase {
	public function testInitialization() {
		$method = 'METHOD';
		$resource = new TestRequest_Error();
		$credentials =  array(
			'auth_token' => 'AUTH_TOKEN',
			'sid' => 'SID'
		);
		$site = 'URL/';

		$request = new Aero_Request($method, $resource, $credentials, $site);

		$this->assertEquals('URL/PATH.json', $request->url);
		$this->assertEquals($method, $request->method);
		$this->assertEquals($credentials['auth_token'], $request->auth_token);
		$this->assertEquals($credentials['sid'], $request->sid);
		$this->assertEquals($resource, $request->resource);
	}
}

class TestRequest_Error {
	public function path() {
		return 'PATH';
	}
}
?>
