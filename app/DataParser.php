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
    public function execute($request, $url = null) {
		if ($url) return $this->sendHttp($request, $url);

		$result = $this->sendCurl($request);
		$this->closeCurl($request);

		return $result;
    }

	public function sendHttp($request, $url) {
		return file_get_contents($url, false, $request);
	}

	public function sendCurl($request) {
		return curl_exec($request);
	}

	public function closeCurl($request) {
		curl_close($request);
	}
}
?>
