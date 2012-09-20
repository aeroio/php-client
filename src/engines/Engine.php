<?php

/**
 * Engine interface.
 *
 * Interface that should be used by all of the supplied engines.
 */
interface Engine {
    public function execute($request);
}

?>
