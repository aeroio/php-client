<?php
require_once 'src/Request.php';

class AeroRequestTest extends PHPUnit_Framework_TestCase {
    public function testInitialization() {
        $type = 'GET';
        $resource = new AeroRequest_Error();
        $resource->id = 1;
        $credentials = array(
            'auth_token' => 'AUTH',
            'sid' => 'SID'
        );

        $result = new Aero_Request($type, $resource, $credentials);
    }
}

class AeroRequest_Error {}
?>
