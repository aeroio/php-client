<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/validators/Validator.php';

class AeroValidatorTest extends PHPUnit_Framework_TestCase {
    public function testValidatePresent() {
        $test = new ValidationResourceTest();

        $test->validate = array(
            'title' => array(
                'presence' => true
            ),
        );

        $this->assertFalse(Aero_Validator::is_valid($test));
    }

    public function testValidateNotPresent() {
        $test = new ValidationResourceTest();
        $test->title = 'present';
        $test->description = null;

        $test->validate = array(
            'title' => array(
                'presence' => true
            ),
        );

        $this->assertTrue(Aero_Validator::is_valid($test));
    }
}

class ValidationResourceTest {}
?>
