<?php
require_once 'src/engines/Curl.php';

class CurlTest extends PHPUnit_Framework_TestCase {
    public function testExecute() {
        $request  = 'request';
        $expected = 'response';

        $curl = $this->getMock('Curl', array('createProcess', 'fetch'));

        $curl->expects($this->once())
            ->method('createProcess')
            ->with($request);
        $curl->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($expected));

        $result = $curl->execute($request);

        $this->assertEquals($expected, $result);
    }

    public function testGetInfoWholeProcess() {
        $curl = new Curl();
        $result = $curl->getInfo();

        $this->assertEquals('array', gettype($result));
    }

    public function testGetInfoAttribute() {
        $expected = 'URL';

        $curl = new Curl();
        $curl->setOption(CURLOPT_URL, $expected);

        $result = $curl->getInfo(CURLINFO_EFFECTIVE_URL);

        $this->assertEquals($expected, $result);
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
