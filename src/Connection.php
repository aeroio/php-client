<?php
class AeroConnection {
	public static function persist($type, $url, $params = null) {
		$url = self::$base . $url;

		$params = array(
			'type' => $type,
			'url' => $url,
			'auth_token' => self::$credentials['auth_token'],
			'sid' => self::$credentials['sid']
		);

		$request = new AeroRequest($params);

		$result = self::$engine->execute($request);

		return $result;
	}

	public static $engine;
	public static $credentials;
	public static $base = 'http://localhost:3000';
}
?>
