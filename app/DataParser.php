<?php
class DataParser {
	public function execute($url, $context) {
		if ($context) {
			return json_encode(file_get_contents($url, false, $context));
		} else {
			return json_encode(file_get_contents($url));
		}
	}
}
?>
