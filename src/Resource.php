<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/engines/Curl.php';
require_once 'src/engines/Http.php';
require_once 'src/Connection.php';
require_once 'src/Request.php';
require_once 'src/Response.php';

/**
 * Base Resource class.
 *
 * This class is extended by the actual resources. It contains the logic for
 * the record that should be got, updated, created or destroyed.
 */
class Aero_Resource {

    /**
     * Request method when getting all records.
     *
     * @var string
     */
    const ALL = 'GET';

    /**
     * Request method when getting a single record.
     *
     * @var string
     */
    const FIRST = 'GET';

    /**
     * Request method when updating an record.
     *
     * @var string
     */
    const UPDATE = 'PUT';

    /**
     * Request method when creating a new record.
     *
     * @var string
     */
    const CREATE = 'POST';

    /**
     * Request method when destroying a record.
     *
     * @var string
     */
    const DESTROY = 'DELETE';

    /**
     * The actual attributes of the record with their values.
     *
     * @var array
     */
    protected $attributes = array();

    /**
     * Constructor, setting the attributes of the resource.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(Array $attributes = array()) {
        foreach ($attributes as $attribute => $value) {
            $this->attributes[$attribute] = $value;
        }
    }

    /**
     * Getting certain attribute from the attributes array, where the information
     * for the object is contained.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) {
        if (array_key_exists($property, $this->attributes)) {
            return $this->attributes[$property];
        }
    }

    /**
     * Check if the property that should be assigned exists in the schema
     * of the object. If it exists, save it to the attributes array.
     *
     * @param string $property
     * @param mixed $value
     * @return void
     */
    public function __set($property, $value) {
        if (in_array($property, $this->schema)) {
            $this->attributes[$property] = $value;
        }
    }

    /**
     * Get all records that the called resource has.
     *
     * @param object $params
     * @return object
     */
    public static function all($params = array()) {
        $class = get_called_class();
        $resource = new $class($params);

        $response = Aero_Connection::persist($resource, self::ALL);

        $array = array();

        foreach($response as $res) {
            $array[] = new $class($res);
        }

        return $array;
    }

    /**
     * Get the first element with the supplied identificator that the called
     * resource has.
     *
     * @param number $id
     * @param object $parent
     * @return object
     */
    public static function first($id, $params = array()) {
        $class = get_called_class();
        $resource = new $class($params);
        $resource->id = $id;

        $response = Aero_Connection::persist($resource, self::FIRST);

        return new $class($response);
    }

    /**
     * Save or update resource, depending on its state. If it's new it will be
     * saved, if not it will be updated.
     *
     * @return object
     */
    public function save() {
        if ($this->isNew()) return $this->send(self::CREATE);

        return $this->send(self::UPDATE);
    }

    /**
     * Destroy this record.
     *
     * @return object
     */
    public function destroy() {
        return $this->send(self::DESTROY);
    }

    /**
     * Send the resource to the connection.
     *
     * @param string $type
     * @return object
     */
    public function send($type) {
        return Aero_Connection::persist($this, $type);
    }

    /**
     * Check if the resource is new.
     *
     * @return bool
     */
    public function isNew() {
        if ($this->id) return false;

        return true;
    }

    /**
     * Return an array containing all of the attributes of this record.
     *
     * @return array
     */
    public function toArray() {
        $array = array();

        foreach ($this->attributes as $key => $value) {
            $array[$key] = $value;
        }

        return $array;
    }
}

?>
