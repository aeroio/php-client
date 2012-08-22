<?php
require_once 'src/Resource.php';

class Aero_Projects extends Aero_Resource {
	public $id;
	public $title;
	public $description;
	public $created_at;
	public $updated_at;
}

Aero_Connection::$engine = new Http();
Aero_Connection::$credentials = array(
	'auth_token' => 'af5550a4f0efede2139568d45f0ce298',
	'sid' => 'db2d7778130f7ff255774aa6c689fd6e'
);

$project = Aero_Projects::all();
print_r($project);
?>
