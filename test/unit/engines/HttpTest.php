<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

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
        $method = 'GET';
        $url = '/v1/projects';
        $context = 'context';

        $engine = $this->getMock('Aero_Http', array(
            'fetch',
            'buildHttpQuery',
			'buildContext',
			'setMethod',
			'setHeader',
			'setContent'
        ));

        $engine->expects($this->once())
            ->method('buildHttpQuery')
            ->will($this->returnValue(true));
        $engine->expects($this->once())
            ->method('buildContext')
            ->will($this->returnValue($context));
        $engine->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($expected));
        $engine->request = 'request';

        $request = $this->getMock('AeroRequest', array(
            'getSid',
            'getAuthToken',
            'getMethod',
            'getUrl'
        ));

        $request->expects($this->once())
            ->method('getSid')
            ->will($this->returnValue($sid));
        $request->expects($this->once())
            ->method('getAuthToken')
            ->will($this->returnValue($auth_token));
        $request->expects($this->once())
            ->method('getMethod')
            ->will($this->returnValue($method));
        $request->expects($this->once())
            ->method('getUrl')
            ->will($this->returnValue($url));

        $result = $engine->execute($request);

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
