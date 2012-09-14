<?php
require_once 'src/engines/Curl.php';
require_once 'src/engines/Http.php';
require_once 'src/Connection.php';
require_once 'src/Request.php';

class Aero_Resource {
	/**
	 * Constructor, setting the options for the resource.
	 *
	 * @params array $attributes
	 * @returns void
	 */
	public function __construct(Array $attributes = null) {
		if ($attributes) {
			foreach ($attributes as $attribute => $value) {
				$this->$attribute = $value;
			}
		}
	}

	// NOT NEEDED
	public function __set($property, $value) {
		if (property_exists($this, $property)) {
			$this->$property = $value;
		}

		return $this;
	}

	// NOT NEEDED?
	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->property();
		}
	}

	// TODO
	public static function all() {
		$type = 'GET';

		$class = get_called_class();
		$resource = new $class();

		$response = Aero_Connection::persist($resource, $type);

		$result = json_decode($response);

		$array = array();
		foreach ($result as $project) {
			if (is_object($project)) {
				$res = get_object_vars($project);
				$array[] = new $class($res);
			}
		}

		return $array;
	}

	//TODO
	public static function first($id) {
		$type = 'GET';

		$class = get_called_class();
		$resource = new $class();
		$resource->id = $id;

		$response = Aero_Connection::persist($resource, $type);
		
		$result = json_decode($response);

		if (is_object($result)) {
			$result = get_object_vars($result);
		}

		return new $class($result);
		//$resource->load_attributes($result);
		//return $resource;
	}

	/**
	 * Saves or updates resource, depending on the type.
	 *
	 * @returns object
	 */
	public function save() {
		$type = 'PUT';

		if ($this->is_new()) $type = 'POST';

		return $this->send($type);
	}

	/**
	 * Destroys resource.
	 *
	 * @returns object
	 */
	public function destroy() {
		$type = 'DELETE';

		return $this->send($type);
	}

	/**
	 * Loads new or updated attributes of the resource.
	 *
	 * @params array $params
	 * @returns void
	 */
	public function load_attributes($params) {
		foreach ($this as $key => $value) {
			if (array_key_exists($key, $params)) {
				$this->$key = $params[$key];
			}
		}
	}

	/**
	 * Checks if the resource is new.
	 *
	 * @returns bool
	 */
	public function is_new() {
		if ($this->id) return false;

		return true;
	}

	/**
	 * Creates an appropriate url.
	 *
	 * @returns string $url
	 */
	public function url() {
		$resource = strtolower(get_called_class());
		$resource = end(explode('_', $resource));

		$url = "/api/v1/$resource";

		if ($this->id) {
			$url .= "/$this->id";
		}

		return $url .= '.json';
	}

	/**
	 * Sends the resource to the connection
	 *
	 * @params string $type
	 * @returns object
	 */
	public function send($type) {
		return Aero_Connection::persist($this, $type);
	}
}
?>
