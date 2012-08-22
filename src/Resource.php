<?php
require_once 'src/engines/Curl.php';
require_once 'src/engines/Http.php';
require_once 'src/Connection.php';
require_once 'src/Request.php';
require_once 'src/resources/Project.php';

class AeroResource {
	public $id;
	public $_attributes = array();

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
		$url = '/api/v1/projects.json';

		return AeroConnection::persist($type, $url);
	}
}
?>
