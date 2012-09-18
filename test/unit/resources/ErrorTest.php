<?php
require_once 'src/resources/Error.php';

class AeroErrorTest extends PHPUnit_Framework_TestCase {
    public function testExtends() {
        $Error = new Aero_Error();

        $this->assertTrue($Error instanceof Aero_Resource);
    }
}
?>
