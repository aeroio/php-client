<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/ExceptionHandler.php';
require_once 'src/Connection.php';
require_once 'src/engines/Curl.php';

/**
 * AeroIO class.
 *
 * Base class for the client.
 */
class AeroIO {

    /**
     * Type of the engine used for the request execution.
     *
     * @var object
     */
    public static $engine;

    /**
     * Url address for the request.
     *
     * @var string
     */
    public static $site;

    /**
     * Auth token for the user authentication.
     *
     * @var string
     */
    public static $auth_token;

    /**
     * Sid for the user authentication.
     *
     * @var string
     */
    public static $sid;

    /**
     * Id of the project to be handled.
     *
     * @var integer
     */
    public static $project;

    /**
     * Set up the options for the request.
     *
     * @param array $options
     * @return void
     */
    public static function configure(Array $options = array()) {
        foreach ($options as $key => $value) {
            self::$$key = $value;
        }

        if (!self::$engine) self::$engine = new Aero_Curl();

        self::setOptions();
    }

    /**
     * Set exception handler for certain project.
     *
     * @return void
     */
    public static function handleExceptions() {
        Aero_ExceptionHandler::for_project(self::$project);
    }

    /**
     * Set the options for the request.
     *
     * @return void
     */
    protected static function setOptions() {
        Aero_Connection::$site = self::$site;
        Aero_Connection::$engine = self::$engine;
        Aero_Connection::$credentials = array(
            'auth_token' => self::$auth_token,
            'sid' => self::$sid
        );
    }
}

?>

