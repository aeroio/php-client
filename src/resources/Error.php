<?php
require_once 'src/resources/Project.php';
require_once 'src/Resource.php';

class Aero_Error extends Aero_Resource {
	public $id;
	public $project_id;
	public $message;
	public $occured;
	public $resolved;
	public $created_at;
	public $updated_at;
}

Aero_Connection::$engine = new Curl();
Aero_Connection::$credentials = array(
	'auth_token' => '52b8963d43b3f9081f58977b5aa3c110',
	'sid' => '4ced755889ec99408be287e3ffb83b6b'
);
$project = Aero_Project::first(2);

$params = array(
	'message' => 'Brand Again New error',
	'project_id' => $project->id
);

//$errors = Aero_Error::all($project);
$error = new Aero_Error($params);
$error->save();
//$error = Aero_Error::first($errors[0]->id, $project);
//$error->destroy();

$errors = Aero_Error::all($project);
print_r($errors);
?>
