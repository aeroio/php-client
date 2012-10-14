<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/Request.php';

class AeroRequestTest extends PHPUnit_Framework_TestCase {
    public function testInitialization() {
        $method = 'METHOD';
        $resource = new TestRequest_Error();
        $credentials =  array(
            'auth_token' => 'AUTH_TOKEN',
            'sid' => 'SID'
        );
        $site = 'URL/';

        $request = new Aero_Request($method, $resource, $credentials, $site);

        $this->assertEquals('URL/PATH.json', $request->getUrl());
        $this->assertEquals($method, $request->getMethod());
        $this->assertEquals($credentials['auth_token'], $request->getAuthToken());
        $this->assertEquals($credentials['sid'], $request->getSid());
        $this->assertEquals($resource, $request->getResource());
    }
}

class TestRequest_Error {
    public function path() {
        return 'PATH';
    }
}
?>
