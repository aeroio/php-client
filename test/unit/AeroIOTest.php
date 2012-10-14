<?php

require_once 'src/AeroIO.php';

class AeroIOTest extends PHPUnit_Framework_TestCase {
    public function testConfigureCredentials() {
        $auth_token = 'AUTH_TOKEN';
        $sid = 'SID';

        AeroIO::configure(array(
            'auth_token' => $auth_token,
            'sid' => $sid
        ));

        $this->assertEquals($auth_token, AeroIO::$auth_token);
    }

    public function testConfigureProject() {
        $project = 1;

        AeroIO::configure(array(
            'project' => $project
        ));

        $this->assertEquals($project, AeroIO::$project);
    }
}

?>
