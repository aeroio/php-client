<?php
require_once 'src/engines/Curl.php';
require_once 'src/engines/Http.php';
require_once 'src/Connection.php';
require_once 'src/Request.php';
require_once 'src/Response.php';
require_once 'src/helpers/StringHelper.php';

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

    /**
     * Gets all elements connected to a certain model.
     *
     * @params object $parent
     * @returns object
     */
    public static function all($params = null) {
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
     * @params number $id
     * @params object $parent
     * @returns object
     */
    public static function first($id, $params = null) {
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
