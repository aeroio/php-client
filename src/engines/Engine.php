<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

/**
 * Engine interface.
 *
 * Interface that should be used by all of the supplied engines.
 */
interface Engine {

    /**
     * Assemble and execute the request.
     *
     * @param object $request
     * @return object
     */
    public function execute($request);
}

?>
