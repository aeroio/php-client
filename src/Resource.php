<?php
require_once 'src/engines/Curl.php';
require_once 'src/engines/Http.php';
require_once 'src/Connection.php';
require_once 'src/Request.php';
require_once 'src/Response.php';

class Aero_Resource {

    // TODO: use those instead of hardcoded string
    const ALL = 0;
    const FIRST = 1;
    const UPDATE = 2;
    const CREATE = 3;
    const DESTROY = 4;

    /**
     * Constructor, setting the options for the resource.
     *
     * TODO: check if static typing is available in PHP 5.2
     * TODO: use the schema
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(Array $attributes = array()) {
        foreach ($attributes as $attribute => $value) {
            $this->attributes[$attribute] = $value;
        }
    }

	public function __get($property) {
		if (array_key_exists($property, $this->attributes)) {
			return $this->attributes[$property];
		}
	}

	public function __set($property, $value) {
		if (in_array($property, $this->schema)) {
			$this->attributes[$property] = $value;
		}
	}

    /**
     * Gets all elements connected to a certain model.
     *
     * @param object $parent
     * @return object
     */
    public static function all($params = array()) {
        $type = 'GET';

        $class = get_called_class();
        $resource = new $class($params);

        $response = Aero_Connection::persist($resource, $type);

        $array = array();

        foreach($response as $res) {
            $array[] = new $class($res);
        }

        return $array;
    }

    /**
     * Gets the first element connected to a certain model.
     *
     * @param number $id
     * @param object $parent
     * TODO: replace params with param and returns with return
     * @return object
     */
    public static function first($id, $params = array()) {
        $type = 'GET';

        $class = get_called_class();
        $resource = new $class($params);
        $resource->id = $id;

        $response = Aero_Connection::persist($resource, $type);

		return new $class($response);
    }

    /**
     * Saves or updates resource, depending on the type.
     *
     * @return object
     */
    public function save() {
        $type = 'PUT';

        if ($this->isNew()) $type = 'POST';

        return $this->send($type);
    }

    /**
     * Destroys resource.
     *
     * @return object
     */
    public function destroy() {
        $type = 'DELETE';

        return $this->send($type);
    }

    /**
     * Loads new or updated attributes of the resource.
     *
     * @param array $params
     * @return void
     */
    public function loadAttributes($params) {
        foreach ($this as $key => $value) {
            if (array_key_exists($key, $params)) {
                $this->$key = $params[$key];
            }
        }
    }

    /**
     * Checks if the resource is new.
     *
     * TODO: camelcase
     * @return bool
     */
    public function isNew() {
        if ($this->id) return false;

        return true;
    }

    /**
     * Sends the resource to the connection
     *
     * @param string $type
     * @return object
     */
    public function send($type) {
        return Aero_Connection::persist($this, $type);
    }
}
?>
