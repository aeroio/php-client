<?php

/**
 * This class connects the components and executes them in such way.
 */
class Aero_Connection {
    /**
     * Credentials to be used for user authorization.
     *
     * @var array
     */
    public static $credentials;

    /**
     * Engine to be used for the request execution.
     *
     * @var object
     */
    public static $engine;

    /**
     * Create a request object, to be used by the engine to execute it.
     *
     * @param object $resource
     * @param string $type
     * @return object
     */
    public static function persist($resource, $type) {
        $request = new Aero_Request($type, $resource, self::$credentials);

        $engine = new self::$engine();
        $response = $engine->execute($request);

        return Aero_Response::handle($response);
    }
}

?>
