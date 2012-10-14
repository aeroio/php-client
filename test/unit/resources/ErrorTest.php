<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/resources/Error.php';

class AeroErrorTest extends PHPUnit_Framework_TestCase {
    public function testExtends() {
        $error = new Aero_Error();

        $this->assertTrue($error instanceof Aero_Resource);
    }

    public function testPathForAllErrors() {
        $error = new Aero_Error();
        $error->project_id = 1;

        $expected = '/projects/1/errors';
        $result = $error->path();

        $this->assertEquals($expected, $result);
    }

    public function testPathForCertainError() {
        $error = new Aero_Error();
        $error->project_id = 1;
        $error->id = 1;

        $expected = '/projects/1/errors/1';
        $result = $error->path();

        $this->assertEquals($expected, $result);

    }
}
?>
