<?php
require_once 'src/validators/Validator.php';

class ValidatorTest extends PHPUnit_Framework_TestCase {
    public function testValidatePresence() {
        $test = new ValidationResourceTest();

        $test->validate = array(
            'title' => array(
                'presence' => true
            ),
        );

        $this->assertFalse(Validator::is_valid($test));
    }

    public function testValidateNotPresence() {
        $test = new ValidationResourceTest();
        $test->title = 'present';

        $test->validate = array(
            'title' => array(
                'presence' => true
            ),
        );

        $this->assertTrue(Validator::is_valid($test));
    }

    public function testValidateMaxLengthOver() {
        $test = new ValidationResourceTest();
        $test->title = 'present';

        $test->validate = array(
            'title' => array(
                'max_length' => 5
            ),
        );

        $this->assertFalse(Validator::is_valid($test));
    }

    public function testValidateMaxLengthUnder() {
        $test = new ValidationResourceTest();
        $test->title = 'present';

        $test->validate = array(
            'title' => array(
                'max_length' => 10
            ),
        );

        $this->assertTrue(Validator::is_valid($test));
    }

    public function testValidateMinLengthOver() {
        $test = new ValidationResourceTest();
        $test->title = 'present';

        $test->validate = array(
            'title' => array(
                'min_length' => 5
            ),
        );

        $this->assertTrue(Validator::is_valid($test));
    }

    public function testValidateMinLengthUnder() {
        $test = new ValidationResourceTest();
        $test->title = 'present';

        $test->validate = array(
            'title' => array(
                'min_length' => 10
            ),
        );

        $this->assertFalse(Validator::is_valid($test));
    }
}

class ValidationResourceTest {}
?>
