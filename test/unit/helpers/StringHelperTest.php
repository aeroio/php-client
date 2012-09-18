<?php
require_once 'src/helpers/StringHelper.php';

class StringHelperTest extends PHPUnit_Framework_TestCase {
    public function testConstructorPrivacy() {
        $reflector = new ReflectionMethod('StringHelper', '__construct');

        $this->assertThat(
            true,
            $this->equalTo($reflector->isPrivate())
        );
    }

    public function testPluralize() {
        $string = 'test';
        $expected = 'tests';

        $result = StringHelper::pluralize($string);

        $this->assertEquals($expected, $result);
    }

    public function testSingularize() {
        $string = 'tests';
        $expected = 'test';

        $result = StringHelper::singularize($string);

        $this->assertEquals($expected, $result);
    }
}
?>
