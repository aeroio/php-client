<?php
require_once 'src/UrlBuilder.php';

class Aero_Connection {
    public static function persist($resource, $type) {
        $request = new Aero_Request($type, $resource, $credentials);
        //$url = UrlBuilder::assemble($resource);

        //$params = array(
            //'type' => $type,
            //'url' => $url,
            //'auth_token' => self::$credentials['auth_token'],
            //'sid' => self::$credentials['sid'],
            //'attributes' => $resource
        //);

        //$request = new Aero_Request($params);

        $engine = new self::$engine();
        $response = $engine->execute($request);

        return Aero_Response::handle($response);
    }

    public static $engine;
    public static $credentials;
}

?>
