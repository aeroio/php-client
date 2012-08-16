<?php
require_once 'src/CurlRequest.php';

class CurlRequestTest extends PHPUnit_Framework_TestCase {
    public function testGetPublicity() {
        $reflector = new ReflectionMethod('CurlRequest', 'get');

        $this->assertThat(
            true,
            $this->equalTo($reflector->isPublic())
        );
    }

    public function testGetWithTokenAndSid() {
        $url = 'www.example.com';
        $request = new CurlRequest($url);

        $auth_token = 'AUTH_TOKEN';
        $sid = 'SID';

        $request->get($auth_token, $sid, $url);
    }

    public function testGetAndSetProcess() {
        $url = 'www.example.com';
        $expected = 'resource';

        $request = new CurlRequest();
        $request->setCurlProcess($url);
        $result = $request->getCurlProcess();

        $this->assertEquals(gettype($result), $expected);
    }

    public function testInitializeTheCurlProcess() {
        $expected = 'resource';

        $request = new CurlRequest();
        $result = $request->getCurlProcess();

        $this->assertEquals(gettype($result), $expected);
    }

    public function testGetProcessInfo() {
        $url = 'www.example.com';
        $request = new CurlRequest();

		$request->setOption(CURLOPT_URL, $url);
        $result = $request->getInfo();

        $this->assertEquals($url, $result['url']);
    }

    public function testGetProcessInfoForAttribute() {
        $url = 'www.example.com';
        $request = new CurlRequest();

		$request->setOption(CURLOPT_URL, $url);
        $result = $request->getInfo(CURLINFO_EFFECTIVE_URL);

        $this->assertEquals($url, $result);
    }

    public function testExecute() {
        $url = 'www.example.com';
        $request = new CurlRequest();

		$request->setOption(CURLOPT_URL, $url);
        $request->execute();
        $result = $request->getInfo();

        $this->assertTrue(!!$result['http_code']);
    }

    public function testSetOption() {
        $url = 'www.example.com';
        $request = new CurlRequest();

        $auth_token = 'AUTH_TOKEN';
        $sid = 'SID';

        $expected = "Authorization: Basic " . base64_encode("$auth_token:$sid");
        $header = array($expected);

		$request->setOption(CURLOPT_URL, $url);
        $request->setOption(CURLOPT_RETURNTRANSFER, true);
        $request->setOption(CURLOPT_HTTPHEADER, $header);
        $request->setOption(CURLINFO_HEADER_OUT, true);
        $request->execute();
        $result = $request->getInfo(CURLINFO_HEADER_OUT);

        $this->assertTrue(!!preg_match('/' . $expected . '/', $result));
    }

    public function testClose() {
        $url = 'www.example.com';
        $request = new CurlRequest($url);

        $request->close();

        try {
            $request->getInfo();
        } catch(Exception $e) { 
            $message = $e->getMessage();
        }

        $this->assertTrue(!!preg_match('/not a valid cURL/', $message));
    }

    public function testBuildHttpQueryWithArray() {
        $request = new CurlRequest();

        $params = array(array('name' => 'Google', 'description' => 'Search engine'));
        $expected = 'name=Google&description=Search+engine';

        $result = $request->buildHttpQuery($params);

        $this->assertEquals($expected, $result);
    }

    public function testBuildHttpQueryWithMixedParams() {
        $request = new CurlRequest();

        $params = array(1, array('name' => 'Google', 'description' => 'Search engine'));
        $expected = 'name=Google&description=Search+engine';

        $result = $request->buildHttpQuery($params);

        $this->assertEquals($expected, $result);
    }

    public function testBuildHttpQueryWithNumericParams() {
        $request = new CurlRequest();

        $params = array(1);
        $expected = null;

        $result = $request->buildHttpQuery($params);

        $this->assertEquals($expected, $result);
    }
}
?>
