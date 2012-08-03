<?php
class DataParser {

	/**
	 * TODO
	 * Executes the request.
	 *
	 * @param string $url
	 * @param object $context
	 * @return object
	 */
	public function execute($url, $context) {
		if ($context) {
			return json_encode(file_get_contents($url, false, $context));
		} else {
			return json_encode(file_get_contents($url));
		}
	}
}
?>
