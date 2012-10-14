<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/Resource.php';

/**
 * Aero_Error class.
 *
 * Resource that has coresponding records in the database, which are with
 * the supplied in the schema format.
 */
class Aero_Error extends Aero_Resource {

    /**
     * Schema, containing the attributes that this record should have.
     *
     * @var array
     */
    protected $schema = array(
        'id',
        'project_id',
        'message',
        'backtrace',
        'class_name',
        'file',
        'line',
        'environment',
        'user_agent',
        'url',
        'hostname',
        'session',
        'params',
        'env_vars',
        'additional_data',
        'occured',
        'resolved',
        'created_at',
        'updated_at'
    );

    /**
     * Assemble the relative path that should be requested.
     *
     * @return string
     */
    public function path() {
    $url = '/projects/' . $this->project_id . '/errors';

        if ($this->id) {
            $url .= "/$this->id";
        }

        return $url;
    }
}

?>
