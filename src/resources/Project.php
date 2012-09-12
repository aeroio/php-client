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
	'auth_token' => '52b8963d43b3f9081f58977b5aa3c110',
	'sid' => '4ced755889ec99408be287e3ffb83b6b'
);

$params = array(
	'title' => 'Changed again',
	'description' => 'Example Description'
);
$projects = Aero_Projects::first(27);
$projects->loadAttributes($params);
$projects->save();
//$project = new Aero_Projects($params);

//$project->save();
?>
