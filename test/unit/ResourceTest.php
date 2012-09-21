<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/Resource.php';

class AeroResourceTest extends PHPUnit_Framework_TestCase {
    public function testSetAndGetAttributes() {
        $expected = 1;
        $aero = new Test_Resource();
        $aero->id = $expected;
        $result = $aero->id;

        $this->assertEquals($expected, $result);
    }

    public function testInitialization() {
        $params = array('id' => 1);
        $expected = $params['id'];

        $aero = new Test_Resource($params);
        $result = $aero->id;

        $this->assertEquals($expected, $result);
    }

    public function testIsNewNegative() {
        $params = array(
            'id' => 1
        );

        $aero = new Test_Resource($params);

        $expected = false;
        $result = $aero->isNew();

        $this->assertEquals($expected, $result);
    }

    public function testIsNewPositive() {
        $aero = new Test_Resource();

        $expected = true;
        $result = $aero->isNew();

        $this->assertEquals($expected, $result);
    }

    public function testSaveNew() {
        $aero = $this->getMock('Test_Resource', array('send', 'isNew'));
        $aero->expects($this->once())
            ->method('send')
            ->with('POST');

        $aero->expects($this->once())
            ->method('isNew')
            ->will($this->returnValue(true));

        $aero->save();
    }

    public function testSaveUpdate() {
        $aero = $this->getMock('Test_Resource', array('send', 'isNew'));
        $aero->expects($this->once())
            ->method('send')
            ->with('PUT');

        $aero->expects($this->once())
            ->method('isNew')
            ->will($this->returnValue(false));

        $aero->save();
    }

    public function testDestroy() {
        $aero = $this->getMock('Test_Resource', array('send'));
        $aero->expects($this->once())
            ->method('send')
            ->with('DELETE');

        $aero->destroy();
    }
}

class Test_Resource extends Aero_Resource {
	public $schema = array(
		'id',
		'title',
		'description'
	);
	public $attributes = array();
}
?>
