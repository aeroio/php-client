<?php
require_once 'app/DataParser.php';

class DataParserTest extends PHPUnit_Framework_TestCase {
    public function testExecutePublicity() {
        $reflector = new ReflectionMethod('DataParser', 'execute');

        $this->assertThat(
            true,
            $this->equalTo($reflector->isPublic())
        );
    }

    public function testExecuteWithCurl() {
        $request = 'request';
        $expected = 'projects';

        $data_parser = $this->getMock('DataParser', array('sendCurl', 'closeCurl'));

        $data_parser->expects($this->once())
            ->method('sendCurl')
            ->will($this->returnValue($expected))
            ->with($request);

        $data_parser->expects($this->once())
            ->method('closeCurl')
            ->with();

        $result = $data_parser->execute($request);

        $this->assertEquals($expected, $result);
    }

    public function testExecuteWithHttp() {
        $request = 'request';
        $url = '/v1/projects';

        $expected = 'projects';

        $data_parser = $this->getMock('DataParser', array('sendHttp'));

        $data_parser->expects($this->once())
            ->method('sendHttp')
            ->will($this->returnValue($expected))
            ->with($request, $url);

        $result = $data_parser->execute($request, $url);

        $this->assertEquals($expected, $result);
    }
}
?>
