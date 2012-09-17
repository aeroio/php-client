<?php
require_once 'src/engines/Curl.php';
require_once 'src/engines/Http.php';
require_once 'src/Connection.php';
require_once 'src/Request.php';
require_once 'src/Response.php';

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
	public static function all($parent = null) {
		$type = 'GET';

		$params = array();
		if ($parent) {
			$value = strtolower(get_class($parent));
			$value = end(explode('_', $value));

			$params = array($value . '_id' => $parent->id);
		}

		$class = get_called_class();
		$resource = new $class($params);

		$response = Aero_Connection::persist($resource, $type);

		foreach($response as $res) {
			$array[] = new $class($res);
		}

		return $array;
	}

	//TODO
	public static function first($id, $parent = null) {
		$type = 'GET';

		$params = array();
		if ($parent) {
			$value = strtolower(get_class($parent));
			$value = end(explode('_', $value));

			$params = array($value . '_id' => $parent->id);
		}

		$class = get_called_class();
		$resource = new $class($params);
		$resource->id = $id;

		$response = Aero_Connection::persist($resource, $type);

		if ($parent) {
			$response['project_id'] = $parent->id;
		}
		
		return new $class($response);
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
		$url = "/api/v1";

		$url .= $this->add_parent();

		$resource = $this->get_name(get_called_class());
		$resource = $this->pluralize($resource);

		$url .= "/$resource";

		if ($this->id) {
			$url .= "/$this->id";
		}

		return $url .= '.json';
	}	

	public function get_name($class) {
		$resource = strtolower($class);

		return end(explode('_', $resource));
	}

	public function pluralize($string) {
		return $string . 's';
	}

	public function singularize($string) {
		return substr_replace($string, "", -1);
	}

	public function add_parent() {
		$attributes = get_object_vars($this);
		
		foreach ($attributes as $key => $value) {
			$parent = strstr($key, '_id', true);

			if ($parent) {
				$parents = $this->pluralize($parent);
				return "/$parents/$value";
			}
		}
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
