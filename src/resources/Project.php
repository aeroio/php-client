<?php
require_once 'src/Resource.php';

class Aero_Projects extends Aero_Resource {
	public $id;
	public $title;
	public $description;
	public $created_at;
	public $updated_at;
}

Aero_Connection::$engine = new Curl();
Aero_Connection::$credentials = array(
	'auth_token' => '52b8963d43b3f9081f58977b5aa3c110',
	'sid' => '4ced755889ec99408be287e3ffb83b6b'
);

$params = array(
	'title' => 'Example change not cadahagaking',
	'description' => 'Example Description'
);
$projects = Aero_Projects::first(33);
$projects->title = 'entirely new';
$projects->save();
//$projects->destroy();
print_r(Aero_Projects::all());

//$project->save();
?>
