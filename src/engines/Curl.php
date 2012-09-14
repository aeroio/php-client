<?php
require_once 'Engine.php';

class Curl implements Engine {
	/**
	 * The process to be executed.
	 *
	 * @var resource
	 */
	private $process;

	/**
	 * Contructor, checking if the engine could work.
	 *
	 * @returns void
	 */
	public function __construct() {
		if (!function_exists('curl_init')) {
			throw new Exception('cURL not installed');
		}

		$this->process = $this->initialize();
	}

	/**
	 * Assembles and executes the process.
	 *
	 * @params object $request
	 * @returns object
	 */
	public function execute($request) {
		$this->createProcess($request);

		return $this->fetch($this->process);
	}

	/**
	 * Creates the whole request, which is to be sent.
	 *
	 * @params object $request
	 * @returns void
	 */
	public function createProcess($request) {
		$sid = $request->sid;
		$auth_token = $request->auth_token;

		$headers = array(
			"Authorization: Basic " . base64_encode("$sid:$auth_token")
		);

		$this->setOption(CURLOPT_URL, $request->url);
		$this->setOption(CURLOPT_RETURNTRANSFER, true);
		$this->setOption(CURLOPT_HTTPHEADER, $headers);

		switch($request->type) {
			case 'POST':
				$this->setOption(CURLOPT_POST, true);
				$this->setOption(CURLOPT_POSTFIELDS, $request->attributes);
				break;
			case 'PUT':
				$this->setOption(CURLOPT_CUSTOMREQUEST, "PUT");
				$this->setOption(CURLOPT_POSTFIELDS, $request->attributes);
				break;
			case 'DELETE':
				$this->setOption(CURLOPT_CUSTOMREQUEST, "DELETE");
				break;
			default:
				$this->setOption(CURLOPT_HTTPGET, true);
		}
	}

	/**
	 * Process initialization.
	 *
	 * @returns resource
	 */
	public function initialize() {
		return curl_init();
	}

	/**
	 * Executes the process and fetches the data.
	 *
	 * @params resource $process
	 * @returns object
	 */
	public function fetch($process) {
		$result = curl_exec($process);

		curl_close($process);

		return $result;
	}

	/**
	 * Gets the process information.
	 *
	 * @params string $name
	 * @returns array
	 */
	public function getInfo($name = null) {
		if ($name) return curl_getinfo($this->process, $name);

		return curl_getinfo($this->process);
	}

	/**
	 * Process options setter.
	 *
	 * @params string $name
	 * @params mixed $value
	 * @returns void
	 */
	public function setOption($name, $value) {
		curl_setopt($this->process, $name, $value);
	}
}
?>
