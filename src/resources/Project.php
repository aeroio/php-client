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

		if (isset($this->attributes['id'])) {
			$id = $this->attributes['id'];
			$url .= "/$id";
		}

		return $url;
	}

	public function toArray() {
		$array = array();

		foreach ($this->attributes as $key => $value) {
			$array[$key] = $value;
		}

		return $array;
	}
}

Aero_Connection::$engine = new Http();
Aero_Connection::$credentials = array(
	'auth_token' => '52b8963d43b3f9081f58977b5aa3c110',
	'sid' => '4ced755889ec99408be287e3ffb83b6b'
);

//$project = Aero_Project::first(2);
$params = array(
	'title' => 'Pretty',
	'descriptions' => 'Desc'
);
//$project = new Aero_Project($params);
//$project->save();
$project = Aero_Project::first(44);
//print_r($project);
$project->title = 'New title aaaexample';
$project->save();
print_r(Aero_Project::first(44));
?>
