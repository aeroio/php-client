<?php
require_once 'src/engines/Curl.php';

class CurlTest extends PHPUnit_Framework_TestCase {
	public function testExecute() {
		$request  = 'request';
		$resource = 'resource';
		$expected = 'response';

		$curl = $this->getMock('Curl', array('createProcess', 'fetch'));

		$curl->expects($this->once())
			->method('createProcess')
			->with($request)
			->will($this->returnValue($resource));
		$curl->expects($this->once())
			->method('fetch')
			->with($resource)
			->will($this->returnValue($expected));

		$result = $curl->execute($request);

		$this->assertEquals($expected, $result);
	}

	public function testCreateProcess() {
		$request = 'request';
		$curl = $this->getMock('Curl', array('initialize', 'setHeaders', 'setType', 'setUrl'));

		//$curl->expects($this->once())
			//->method('initialize')
			//->with();
		//$curl->expects($this->once())
			//->method('setHeaders')
			//->with($request);
		//$curl->expects($this->once())
			//->method('setType')
			//->with($request);
		//$curl->expects($this->once())
			//->method('setUrl')
			//->with($request);

		//$curl->createProcess($request);
	}
	
	public function testGetInfoWholeProcess() {
		$curl = new Curl();
		$curl->initialize();
		$result = $curl->getInfo();

		$this->assertEquals('array', gettype($result));
	}

	public function testGetInfoAttribute() {
		$curl = new Curl();
		$curl->initialize();
		$result = $curl->getInfo(CURLOPT_URL);

		$this->assertEquals('NULL', gettype($result));
	}

	public function testSetOption() {
		$curl = new Curl();
		$curl->initialize();

		$expected = 'url';

		$curl->setOption(CURLOPT_URL, $expected);

		$result = $curl->getInfo();

		$this->assertEquals($expected, $result['url']);
	}
}
?>
