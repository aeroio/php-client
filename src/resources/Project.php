<?php
require_once 'src/Resource.php';

class AeroProject extends AeroResource {

}

AeroConnection::$engine = new Http();
AeroConnection::$credentials = array(
	'auth_token' => 'af5550a4f0efede2139568d45f0ce298',
	'sid' => 'db2d7778130f7ff255774aa6c689fd6e'
);

$projects = AeroProject::all();
print_r($projects);
?>
