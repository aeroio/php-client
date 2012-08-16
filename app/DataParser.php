<?php
class DataParser {
    /**
     * Executes the provided request and returns the response.
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

	/**
	 * Sends a request to the provided url and returns the response.
	 *
	 * @param resource $request
	 * @param url $url
	 * @return object
	 */
	public function sendHttp($request, $url) {
		return file_get_contents($url, false, $request);
	}

	/**
	 * Executes the request which has url and all data in itself.
	 *
	 * @param resource $request
	 * @return object
	 */
	public function sendCurl($request) {
		return curl_exec($request);
	}

	/**
	 * Closes the cURL process.
	 *
	 * @param resource $request
	 * @return void
	 */
	public function closeCurl($request) {
		curl_close($request);
	}
}
?>
