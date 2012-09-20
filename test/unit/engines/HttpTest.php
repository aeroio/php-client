<?php
require_once 'src/engines/Http.php';

class HttpTest extends PHPUnit_Framework_TestCase {
    public function testExecutePublicity() {
        $reflector = new ReflectionMethod('Aero_Http', 'execute');

        $this->assertThat(
            true,
            $this->equalTo($reflector->isPublic())
        );
    }

    public function testExecuteWithTokenAndSid() {
        $auth_token = 'AUTH_TOKEN';
        $sid = 'SID';
        $expected = 'response';

        $engine = $this->getMock('Aero_Http', array('fetch', 'buildHttpQuery'));

        $engine->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($expected));

        $request->auth_token = $auth_token;
        $request->sid = $sid;
        $request->url = '/v1/projects';
        $request->method = 'GET';

        $result = $engine->execute($request);

        $expectedMethod = 'GET';

        $this->assertEquals($expectedMethod, $engine->getMethod());
        $this->assertEquals($result, $expected);
    }

    public function testSetAndGetHeader() {
        $request = new Aero_Http();

        $expected = 'header';
        $request->setHeader($expected);
        $result = $request->getHeader();

        $this->assertEquals($expected, $result);
    }

    public function testSetAndGetContent() {
        $request = new Aero_Http();

        $expected = 'content';
        $request->setContent($expected);
        $result = $request->getContent();

        $this->assertEquals($expected, $result);
    }

    public function testSetAndGetMethod() {
        $request = new Aero_Http();

        $actual = 'method';
        $request->setMethod($actual);
        $result = $request->getMethod();
        $expected = 'METHOD';

        $this->assertEquals($expected, $result);
    }

    public function testBuildContext() {
        $request = new Aero_Http();

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
