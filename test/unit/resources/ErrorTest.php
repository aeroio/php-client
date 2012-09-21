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
        $Error = new Aero_Error();

        $this->assertTrue($Error instanceof Aero_Resource);
    }
}
?>
