<?php
class Aero_Connection {
	public static function persist($resource, $type) {
		$url = self::$base . $resource->url();

		$params = array(
			'type' => $type,
			'url' => $url,
			'auth_token' => self::$credentials['auth_token'],
			'sid' => self::$credentials['sid'],
			'attributes' => $resource
		);

		$request = new Aero_Request($params);

		$engine = new self::$engine();
		return $engine->execute($request);
	}

	public static $engine;
	public static $credentials;
	private static $base = 'http://localhost:3000';
}
?>
