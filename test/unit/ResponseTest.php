<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/Response.php';

class ResponseTest extends PHPUnit_Framework_TestCase {
    public function testReshapeWithSingleObject() {
        $response = '{"title":"TITLE"}';

        $expected = array(
            'title' => 'TITLE'
        );
        $result = Aero_Response::reshape($response);

        $this->assertEquals($expected, $result);
    }

    public function testReshapeMultipleObjects() {
        $response = '[{"title":"TITLE"}, {"title":"TITLE2"}]';

        $expected = array(
            array('title' => 'TITLE'),
            array('title' => 'TITLE2')
        );
        $result = Aero_Response::reshape($response);

        $this->assertEquals($expected, $result);
    }

    public function testResponseCodeWhenCurl() {
        $expected = 200;

        $array = array(
            'http_code' => $expected
        );

        $result = Aero_Response::responseCode($array);

        $this->assertEquals($expected, $result);
    }

    public function testResponseCodeWhenHttp() {
        $expected = 200;

        $array = array("HTTP/1.1 $expected OK", 'OTHER', 'DATA');

        $result = Aero_Response::responseCode($array);

        $this->assertEquals($expected, $result);
    }

    public function testRaiseRedirectionExceptionWhen301() {
        $this->setExpectedException('RedirectionException');

        $response['header']['http_code'] = 301;

        Aero_Response::handle($response);
    }

    public function testRaiseRedirectionExceptionWhen302() {
        $this->setExpectedException('RedirectionException');

        $response['header']['http_code'] = 302;

        Aero_Response::handle($response);
    }

    public function testRaiseRedirectionExceptionWhen303() {
        $this->setExpectedException('RedirectionException');

        $response['header']['http_code'] = 303;

        Aero_Response::handle($response);
    }

    public function testRaiseRedirectionExceptionExceptionWhen307() {
        $this->setExpectedException('RedirectionException');

        $response['header']['http_code'] = 307;

        Aero_Response::handle($response);
    }

    public function testRaiseBadRequestExceptionWhen400() {
        $this->setExpectedException('BadRequestException');

        $response['header']['http_code'] = 400;

        Aero_Response::handle($response);
    }

    public function testRaiseUnauthorizedExceptionWhen401() {
        $this->setExpectedException('UnauthorizedException');

        $response['header']['http_code'] = 401;

        Aero_Response::handle($response);
    }

    public function testRaiseForbiddenAccessExceptionWhen403() {
        $this->setExpectedException('ForbiddenAccessException');

        $response['header']['http_code'] = 403;

        Aero_Response::handle($response);
    }

    public function testRaiseResourceNotFoundExceptionWhen404() {
        $this->setExpectedException('ResourceNotFoundException');

        $response['header']['http_code'] = 404;

        Aero_Response::handle($response);
    }

    public function testRaiseMethodNotAllowedExceptionWhen405() {
        $this->setExpectedException('MethodNotAllowedException');

        $response['header']['http_code'] = 405;

        Aero_Response::handle($response);
    }

    public function testRaiseResourceConflictExceptionWhen409() {
        $this->setExpectedException('ResourceConflictException');

        $response['header']['http_code'] = 409;

        Aero_Response::handle($response);
    }

    public function testRaiseResourceGoneExceptionWhen410() {
        $this->setExpectedException('ResourceGoneException');

        $response['header']['http_code'] = 410;

        Aero_Response::handle($response);
    }

    public function testRaiseResourceInvalidExceptionWhen422() {
        $this->setExpectedException('ResourceInvalidException');

        $response['header']['http_code'] = 422;

        Aero_Response::handle($response);
    }

    public function testRaiseServerExceptionWhenBetween500and600() {
        $this->setExpectedException('ServerException');

        $response['header']['http_code'] = rand(500, 600);

        Aero_Response::handle($response);

    }

    public function testRaiseConnectionExceptionWhenNotAnyCase() {
        $this->setExpectedException('ConnectionException');

        $response['header']['http_code'] = 1000;

        Aero_Response::handle($response);
    }
}

?>
