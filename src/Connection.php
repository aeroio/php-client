<?php
require_once 'src/UrlBuilder.php';

class Aero_Connection {
    public static function persist($resource, $type) {
        $request = new Aero_Request($type, $resource, self::$credentials);

        $engine = new self::$engine();
        $response = $engine->execute($request);

        return Aero_Response::handle($response);
    }

    public static $engine;
    public static $credentials;
}

?>
