<?php
require_once 'src/engines/Curl.php';
require_once 'src/engines/Http.php';
require_once 'src/Connection.php';
require_once 'src/Request.php';
require_once 'src/resources/Project.php';

class Aero_Resource {
	public function __construct(Array $attributes = null) {
		if ($attributes) {
			foreach ($attributes as $attribute => $value) {
				$this->$attribute = $value;
			}
		}
	}

	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}

		return $this;
	}

	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->property();
		}
	}

	public static function all() {
		$type = 'GET';

		$klass = get_called_class();
		$resource = new $klass();

		$response = Aero_Connection::persist($type, $resource);

		$result = json_decode($response);

		$array = array();
		foreach ($result as $project) {
			if (is_object($project)) {
				$res = get_object_vars($project);
				$array[] = new Aero_Projects($res);
			}
		}

		// $project->loadAttributes($result);

		return $array;
	}

	public static function first($id) {
		$type = 'GET';

		$klass = get_called_class();
		$resource = new $klass();
		$resource->id = $id;

		$response = Aero_Connection::persist($type, $resource);
		
		$result = json_decode($response);

		if (is_object($result)) {
			$result = get_object_vars($result);
		}

		// $project->load_attributes($result);

		return new Aero_Projects($result);
	}

	public function save() {
		$type = 'POST';

		if ($this->id) $type = 'PUT';

		$response = Aero_Connection::persist($type, $this);
		print_r($response);
	}

	public function loadAttributes($params) {
		foreach ($this as $key => $value) {
			if (array_key_exists($key, $params)) {
				$this->$key = $params[$key];
			}
		}
	}

	public function url() {
		$resource = strtolower(get_called_class());
		$resource = end(explode('_', $resource));

		$url = "/api/v1/$resource";

		if ($this->id) {
			$url .= "/$this->id";
		}

		return $url .= '.json';
	}

}
?>
