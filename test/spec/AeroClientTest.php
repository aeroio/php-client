<?php
require_once 'app/AeroClient.php';

class AeroClientTest extends PHPUnit_Framework_TestCase {
	public function testInitializeDataParser() {
		$aero = new AeroClient();
		$data_parser = $aero->getDataParser();

		$this->assertInstanceOf('DataParser', $data_parser);
	}

	public function testSetDataParser() {
		$aero = new AeroClient();
		$expected = 'New Data Parser';
		$aero->setDataParser($expected);
		$result = $aero->getDataParser();

		$this->assertEquals($expected, $result);
	}

	public function testInitializeRequest() {
		$aero = new AeroClient();
		$request = $aero->getRequest();

		$this->assertInstanceOf('Request', $request);
	}

	public function testSetRequest() {
		$aero = new AeroClient();
		$expected = 'New Request';
		$aero->setRequest($expected);
		$result = $aero->getRequest();

		$this->assertEquals($expected, $result);
	}

	public function testGetRequestParamsForAllProjects() {
		$expected = array('type' => 'get', 'url' => '/v1/projects');

		$aero = new AeroClient();
		$result = $aero->getRequestParams('getProjects');

		$this->assertEquals($expected, $result);
	}

	public function testGetRequestParamsForProjectWithID() {
		$expected = array('type' => 'get', 'url' => '/v1/project');

		$aero = new AeroClient();
		$result = $aero->getRequestParams('getProject');

		$this->assertEquals($expected, $result);
	}

	public function testGetRequestParamsForProjectCreation() {
		$expected = array('type' => 'post', 'url' => '/v1/projects');

		$aero = new AeroClient();
		$result = $aero->getRequestParams('createProject');

		$this->assertEquals($expected, $result);
	}

	public function testGetRequestParamsForProjectUpdate() {
		$expected = array('type' => 'put', 'url' => '/v1/project');

		$aero = new AeroClient();
		$result = $aero->getRequestParams('updateProject');

		$this->assertEquals($expected, $result);
	}

	public function testCreateContext() {
		$aero = new AeroClient();

		$expected = 'request';
		$request = $this->getMock('Request', array('get'));

		$request->expects($this->once())
			->method('get')
			->will($this->returnValue($expected))
			->with();

		$aero->setRequest($request);

		$type = 'get';
		$result = $aero->createContext($type);

		$this->assertEquals($expected, $result);
	}

	public function testSendHttpRequest() {
		$aero = new AeroClient();

		$expected = 'response';
		$data_parser = $this->getMock('DataParser', array('execute'));

		$data_parser->expects($this->once())
			->method('execute')
			->will($this->returnValue($expected))
			->with();

		$aero->setDataParser($data_parser);

		$url = 'url';
		$context = 'context';
		$result = $aero->sendHttpRequest($url, $context);

		$this->assertEquals($expected, $result);
	}

	public function testRequestExecutionWhenMethodExists() {
		$aero = new AeroClient();
		$expected = 'projects';

		$context = 'context';
		$request = $this->getMock('Request', array('get'));
		$request->expects($this->once())
			->method('get')
			->will($this->returnValue($context))
			->with();

		$url = '/v1/projects';
		$data_parser = $this->getMock('DataParser', array('execute'));
		$data_parser->expects($this->once())
			->method('execute')
			->will($this->returnValue($expected))
			->with($this->equalTo($url));

		$aero->setRequest($request);
		$aero->setDataParser($data_parser);
		$result = $aero->getProjects();

		$this->assertEquals($expected, $result);
	}

	public function testRequestExecutionWhenMethodDoesntExists() {
		$aero = new AeroClient();

		$expected = 'Invalid Method';

		try {
			$aero->sendProjects();
		} catch (Exception $e) { 
			$result = $e->getMessage();
		}

		$this->assertEquals($result, $expected);
	}

	public function testBuildUrlWithGivenNumericValueAsArgument() {
		$aero = new AeroClient();

		$url = '/v1/project';
		$arguments = 1;
		$expected = '/v1/project/1';

		$result = $aero->buildUrl($url, $arguments);

		$this->assertEquals($expected, $result);
	}


	public function testBuildUrlWithGivenArrayAndNumericValueAsArguments() {
		$aero = new AeroClient();

		$url = '/v1/project';
		$arguments = array(1, array('name' => 'Twitter', 'description' => 'Twitt Twitt'));
		$expected = '/v1/project/1';

		$result = $aero->buildUrl($url, $arguments);

		$this->assertEquals($expected, $result);
	}

	public function testBuildUrlWithGivenArrayForCreation() {
		$aero = new AeroClient();

		$url = '/v1/project';
		$arguments = array(array('name' => 'Twitter', 'description' => 'Nice tool'));
		$expected = '/v1/project';

		$result = $aero->buildUrl($url, $arguments);

		$this->assertEquals($expected, $result);

	}
}
?>
