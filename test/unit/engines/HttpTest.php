<?php
require_once 'src/engines/Http.php';

class HttpTest extends PHPUnit_Framework_TestCase {
    public function testExecutePublicity() {
        $reflector = new ReflectionMethod('Http', 'execute');

        $this->assertThat(
            true,
            $this->equalTo($reflector->isPublic())
        );
    }

	public function testExecuteWithTokenAndSid() {
		$auth_token = 'AUTH_TOKEN';
		$sid = 'SID';
		$expected = 'response';

		$engine = $this->getMock('Http', array('fetch'));

		$engine->expects($this->once())
			->method('fetch')
			->will($this->returnValue($expected));

		$request->auth_token = $auth_token;
		$request->sid = $sid;
		$request->url = '/v1/projects';
		$request->type = 'GET';

        $result = $engine->execute($request);

        $expectedMethod = 'GET';
		$expectedHeader = 'Authorization: Basic ' . base64_encode("$sid:$auth_token") .
						  "Connection: close\r\n";

        $this->assertEquals($expectedMethod, $engine->getMethod());
        $this->assertEquals($expectedHeader, $engine->getHeader());
		$this->assertEquals($result, $expected);
	}

	public function testBuildHttpQueryWithArray() {
        $request = new Http();

        $params = array(array('name' => 'Google', 'description' => 'Search engine'));
        $expected = 'name=Google&description=Search+engine';

        $result = $request->buildHttpQuery($params);

        $this->assertEquals($expected, $result);
    }

    public function testBuildHttpQueryWithMixedParams() {
        $request = new Http();

        $params = array(1, array('name' => 'Google', 'description' => 'Search engine'));
        $expected = 'name=Google&description=Search+engine';

        $result = $request->buildHttpQuery($params);

        $this->assertEquals($expected, $result);
    }


    public function testBuildHttpQueryWithNumericParams() {
        $request = new Http();

        $params = array(1);
        $expected = null;

        $result = $request->buildHttpQuery($params);

        $this->assertEquals($expected, $result);
    }

	public function testSetAndGetHeader() {
        $request = new Http();

        $expected = 'header';
        $request->setHeader($expected);
        $result = $request->getHeader();

        $this->assertEquals($expected, $result);
    }

    public function testSetAndGetContent() {
        $request = new Http();

        $expected = 'content';
        $request->setContent($expected);
        $result = $request->getContent();

        $this->assertEquals($expected, $result);
    }

    public function testSetAndGetMethod() {
        $request = new Http();

        $actual = 'method';
        $request->setMethod($actual);
        $result = $request->getMethod();
        $expected = 'METHOD';

        $this->assertEquals($expected, $result);
    }

	public function testBuildContext() {
        $request = new Http();

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
