<?php
require_once 'src/Response.php';

class ResponseTest extends PHPUnit_Framework_TestCase {
    public function testHandleSingleObject() {
        $response = '{"title":"TITLE"}';

        $expected = array(
            'title' => 'TITLE'
        );
        $result = Aero_Response::handle($response);

        $this->assertEquals($expected, $result);
    }

    public function testHandleMultipleObjects() {
        $response = '[{"title":"TITLE"}, {"title":"TITLE2"}]';

        $expected = array(
            array('title' => 'TITLE'),
            array('title' => 'TITLE2')
        );
        $result = Aero_Response::handle($response);

        $this->assertEquals($expected, $result);
    }
}
class Test_Response {}
?>
