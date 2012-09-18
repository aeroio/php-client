<?php
require_once 'src/UrlBuilder.php';

class UrlBuilderTest extends PHPUnit_Framework_TestCase {
    public function testConstructorPrivacy() {
        $reflector = new ReflectionMethod('UrlBuilder', '__construct');

        $this->assertThat(
            true,
            $this->equalTo($reflector->isPrivate())
        );
    }

    public function testAssembleFullUrl() {
        $resource = new Test_Error();
        $resource->id = 1;
        $resource->project_id = 1;
        $format = 'xml';

        $expected = '/projects/1/errors/1.xml';

        $result = UrlBuilder::assemble($resource, $format);

        $this->assertTrue(strpos($result, $expected) == true);
    }

    public function testAssembleAddsParents() {
        $resource = 'resource';

        $urlBuilder = $this->getMockClass('UrlBuilder', array('add_parent', 'add_current'));

        $urlBuilder::staticExpects($this->once())
            ->method('add_parent')
            ->with($resource);

        $urlBuilder::assemble($resource);
    }

    public function testAssembleAddsCurrentResource() {
        $resource = 'resource';

        $urlBuilder = $this->getMockClass('UrlBuilder', array('add_current', 'add_parent'));

        $urlBuilder::staticExpects($this->once())
            ->method('add_current')
            ->with($resource);

        $urlBuilder::assemble($resource);
    }

    public function testReturnsRightFormat() {
        $resource = 'resource';
        $format = 'json';
        $expected = '.json';

        $urlBuilder = $this->getMockClass('UrlBuilder', array('add_parent', 'add_current'));

        $url = $urlBuilder::assemble($resource, $format);

        $length = strlen($expected);
        $result = substr($expected, -$length);

        $this->assertEquals($expected, $result);
    }

    public function testAddParentWhenThereIsSuch() {
        $resource = $this->getMock('Resource');
        $resource->project_id = 1;

        $expected = '/projects/1';
        $result = UrlBuilder::add_parent($resource);

        $this->assertEquals($expected, $result);
    }

    public function testAddParentWhenThereIsNot() {
        $resource = $this->getMock('Resource');

        $expected = '';
        $result = UrlBuilder::add_parent($resource);

        $this->assertEquals($expected, $result);
    }

    public function testAddCurrent() {
        $resource = new Test_Error();
        $resource->id = 1;

        $expected = '/errors/1';
        $result = UrlBuilder::add_current($resource);

        $this->assertEquals($expected, $result);
    }
}

class Test_Error {}
?>
