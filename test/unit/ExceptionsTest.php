<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/Exceptions.php';

class ExceptionsTest extends PHPUnit_Framework_TestCase {
    public function testClientException() {
        $this->setExpectedException('ClientException');

        $exception = new ClientException('message');

        $this->assertTrue($exception instanceof Exception);

        throw $exception;
    }

    public function testServerException() {
        $this->setExpectedException('ServerException');

        $exception = new ServerException('message');

        $this->assertTrue($exception instanceof Exception);

        throw $exception;
    }

    public function testConnectionException() {
        $this->setExpectedException('ConnectionException');

        $exception = new ConnectionException('message');

        $this->assertTrue($exception instanceof Exception);

        throw $exception;
    }

    public function testRedirectionException() {
        $this->setExpectedException('RedirectionException');

        $exception = new RedirectionException('message');

        $this->assertTrue($exception instanceof ConnectionException);

        throw $exception;
    }

    public function testBadRequestException() {
        $this->setExpectedException('BadRequestException');

        $exception = new BadRequestException('message');

        $this->assertTrue($exception instanceof ClientException);

        throw $exception;
    }
    
    public function testUnauthorizedException() {
        $this->setExpectedException('UnauthorizedException');

        $exception = new UnauthorizedException('message');

        $this->assertTrue($exception instanceof ClientException);

        throw $exception;
    }
    
    public function testForbiddenAccessException() {
        $this->setExpectedException('ForbiddenAccessException');

        $exception = new ForbiddenAccessException('message');

        $this->assertTrue($exception instanceof ClientException);

        throw $exception;
    }
    
    public function testResourceNotFoundException() {
        $this->setExpectedException('ResourceNotFoundException');

        $exception = new ResourceNotFoundException('message');

        $this->assertTrue($exception instanceof ClientException);

        throw $exception;
    }
    
    public function testMethodNotAllowedException() {
        $this->setExpectedException('MethodNotAllowedException');

        $exception = new MethodNotAllowedException('message');

        $this->assertTrue($exception instanceof ClientException);

        throw $exception;
    }
    
    public function testResourceConflictException() {
        $this->setExpectedException('ResourceConflictException');

        $exception = new ResourceConflictException('message');

        $this->assertTrue($exception instanceof ClientException);

        throw $exception;
    }

    public function testResourceGoneException() {
        $this->setExpectedException('ResourceGoneException');

        $exception = new ResourceGoneException('message');

        $this->assertTrue($exception instanceof ClientException);

        throw $exception;
    }

    public function testResourceInvalidException() {
        $this->setExpectedException('ResourceInvalidException');

        $exception = new ResourceInvalidException('message');

        $this->assertTrue($exception instanceof ClientException);

        throw $exception;
    }
}

?>
