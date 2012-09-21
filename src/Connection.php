<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

/**
 * Aero_Connection class.
 *
 * This class connects the components and executes them.
 */
class Aero_Connection {

    /**
     * Base url of the application.
     *
     * @static string
     */
    public static $site = 'http://localhost:3000/api/v1';

    /**
     * Credentials to be used for user authorization.
     *
     * @static array
     */
    public static $credentials;

    /**
     * Engine to be used for the request execution.
     *
     * @static object
     */
    public static $engine;

    /**
     * Create a request object, to be used by the engine for execution and
     * handle the response.
     *
     * @param object $resource
     * @param string $type
     * @return object
     */
    public static function persist($resource, $type) {
        $request = new Aero_Request($type, $resource, self::$credentials, self::$site);

        $engine = new self::$engine();
        $response = $engine->execute($request);

        return Aero_Response::handle($response);
    }
}

?>
