<?php

require_once 'src/Resource.php';

class Aero_Project extends Aero_Resource {
    /**
     * TODO: use schema
     */
    protected $schema = array(
        'id',
        'title',
		'description',
		'created_at',
		'updated_at'
    );

    protected $attributes = array();

	public function path() {
		$url = '/projects';

		$id = $this->attributes['id'];
		if ($id) $url .= "/$id";

		return $url;
	}
}

Aero_Connection::$engine = new Http();
Aero_Connection::$credentials = array(
	'auth_token' => '52b8963d43b3f9081f58977b5aa3c110',
	'sid' => '4ced755889ec99408be287e3ffb83b6b'
);

$project = Aero_Project::first(2);
print_r($project);
print_r($project->created_at);


?>
