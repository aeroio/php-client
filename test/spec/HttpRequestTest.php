<?php
require_once 'app/HttpRequest.php';

class HttpRequestTest extends PHPUnit_Framework_TestCase {
    public function testGetPublicity() {
        $reflector = new ReflectionMethod('HttpRequest', 'get');

        $this->assertThat(
            true,
            $this->equalTo($reflector->isPublic())
        );
    }

    public function testGetWithTokenAndSid() {
        $request = new HttpRequest();

        $auth_token = 'AUTH_TOKEN';
        $sid = 'SID';

        $request->get($auth_token, $sid);

        $expectedMethod = 'GET';
        $expectedHeader = 'Authorization: Basic ' . base64_encode("$auth_token:$sid");

        $this->assertEquals($expectedMethod, $request->getMethod());
        $this->assertEquals($expectedHeader, $request->getHeader());
    }

    public function testPostPublicity() {
        $reflector = new ReflectionMethod('HttpRequest', 'post');

        $this->assertThat(
            true,
            $this->equalTo($reflector->isPublic())
        );
    }

    public function testPostWithTokenAndSid() {
        $request = new HttpRequest();

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
        $reflector = new ReflectionMethod('HttpRequest', 'put');

        $this->assertThat(
            true,
            $this->equalTo($reflector->isPublic())
        );
    }

    public function testPutWithTokenAndSid() {
        $request = new HttpRequest();

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

	public function testDeleteWithTokenAndSid() {
        $request = new HttpRequest();

        $auth_token = 'AUTH_TOKEN';
        $sid = 'SID';
        $params = array(array('name' => 'Google'));
        $query = $request->buildHttpQuery($params);

        $request->delete($auth_token, $sid, $params);

        $expectedMethod = 'DELETE';
        $expectedHeader = 'Authorization: Basic ' . base64_encode("$auth_token:$sid") .
                          "Connection: close\r\n" .
                          "Content-Length: " . strlen($query) . "\r\n";

        $this->assertEquals($expectedMethod, $request->getMethod());
        $this->assertEquals($expectedHeader, $request->getHeader());
        $this->assertEquals($query,  $request->getContent());
	}

    public function testBuildHttpQueryWithArray() {
        $request = new HttpRequest();

        $params = array(array('name' => 'Google', 'description' => 'Search engine'));
        $expected = 'name=Google&description=Search+engine';

        $result = $request->buildHttpQuery($params);

        $this->assertEquals($expected, $result);
    }

    public function testBuildHttpQueryWithMixedParams() {
        $request = new HttpRequest();

        $params = array(1, array('name' => 'Google', 'description' => 'Search engine'));
        $expected = 'name=Google&description=Search+engine';

        $result = $request->buildHttpQuery($params);

        $this->assertEquals($expected, $result);
    }


    public function testBuildHttpQueryWithNumericParams() {
        $request = new HttpRequest();

        $params = array(1);
        $expected = null;

        $result = $request->buildHttpQuery($params);

        $this->assertEquals($expected, $result);
    }

    public function testSetAndGetHeader() {
        $request = new HttpRequest();

        $expected = 'header';
        $request->setHeader($expected);
        $result = $request->getHeader();

        $this->assertEquals($expected, $result);
    }

    public function testSetAndGetContent() {
        $request = new HttpRequest();

        $expected = 'content';
        $request->setContent($expected);
        $result = $request->getContent();

        $this->assertEquals($expected, $result);
    }

    public function testSetAndGetMethod() {
        $request = new HttpRequest();

        $actual = 'method';
        $request->setMethod($actual);
        $result = $request->getMethod();
        $expected = 'METHOD';

        $this->assertEquals($expected, $result);
    }

    public function testBuildContext() {
        $request = new HttpRequest();

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
