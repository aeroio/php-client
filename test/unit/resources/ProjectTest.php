<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/resources/Project.php';

class AeroProjectTest extends PHPUnit_Framework_TestCase {
    public function testExtends() {
        $project = new Aero_Project();

        $this->assertTrue($project instanceof Aero_Resource);
    }

    public function testPathForAllProjects() {
        $project = new Aero_Project();

        $expected = '/projects';
        $result = $project->path();

        $this->assertEquals($expected, $result);
    }

    public function testPathForCertainProjects() {
        $project = new Aero_Project();
        $project->id = 1;

        $expected = '/projects/1';
        $result = $project->path();

        $this->assertEquals($expected, $result);
    }
}
?>
