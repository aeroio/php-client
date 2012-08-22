<?php

class Aero_Connection {
	public static function persist($type, $resource) {
		$url = self::$base . $resource->url();

		$params = array(
			'type' => $type,
			'url' => $url,
			'auth_token' => self::$credentials['auth_token'],
			'sid' => self::$credentials['sid']
		);

		$request = new Aero_Request($params);

		$result = self::$engine->execute($request);

		return $result;
	}

	public static $engine;
	public static $credentials;
	private static $base = 'http://localhost:3000';
}
?>
