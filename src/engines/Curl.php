<?php
class Curl {
	public $process;

	public function __construct() {
		if (!function_exists('curl_init')) {
			return false;
		}
		$this->process = $this->initialize();
	}

	public function execute($request) {
		$this->createProcess($request);

		return $this->fetch($this->process);
	}

	public function fetch($process) {
		$result = curl_exec($process);
		curl_close($process);

		return $result;
	}

	public function createProcess($request) {
		$sid = $request->sid;
		$auth_token = $request->auth_token;

		$headers = array(
			"Authorization: Basic " . base64_encode("$sid:$auth_token")
		);

		$this->setOption(CURLOPT_URL, $request->url);
		$this->setOption(CURLOPT_RETURNTRANSFER, true);
		$this->setOption(CURLOPT_HTTPHEADER, $headers);
		$this->setOption(CURLOPT_HTTPGET, true);
	}

	public function initialize() {
		return curl_init();
	}

	public function getInfo($name = null) {
		if ($name) return curl_getinfo($this->process, $name);

		return curl_getinfo($this->process);
	}

	public function setOption($name, $value) {
		curl_setopt($this->process, $name, $value);
	}
}
?>
