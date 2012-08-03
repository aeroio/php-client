<?php
require_once 'Request.php';
require_once 'DataParser.php';

class AeroClient {

	/**
	 * Request Object.
	 *
	 * @var object
	 */
	private $request;

	/**
	 * DataParser Object.
	 *
	 * @var object
	 */
	private $data_parser;

	/**
	 * Configuration options for the available requests.
	 *
	 * @var array
	 */
	private $routes = array(
		'getProjects' => array('type' => 'get', 'url' => '/v1/projects')
	);

	/**
	 * Constructor. Initializes dependencies objects.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->request = new Request();
		$this->data_parser = new DataParser();
	}

	/**
	 * Magic method, executed when non-existent method is called. It checks, if the method
	 * is listed in the available methods and the returns the needed data, then calls the
	 * appropriate request method from and sets the context and if the context is set,
	 * sends the request to the provided URL.
	 *
	 * @param string $method
	 * @param mixed  $arguments
	 * @return object or string Server Response or non-existence message.
	 */
	public function __call($method, $arguments = null) {
		$data = $this->getRequestParams($method);

		if ($data) {
			$context = $this->createContext($data['type'], $arguments);
			if ($context) {
				return $this->sendHttpRequest($data['url'], $context);
			}
		} else {
			return 'Such method does not exist';
		}
	}

	/**
	 * Gets the DataParser object.
	 *
	 * @return object
	 */
	public function getDataParser() {
		return $this->data_parser;
	}

	/**
	 * Sets DataParser object.
	 *
	 * @param object $data_parser
	 * @return void
	 */
	public function setDataParser($data_parser) {
		$this->data_parser = $data_parser;
	}

	/**
	 * Gets the Request object.
	 *
	 * @return object
	 */
	public function getRequest() {
		return $this->request;
	}

	/**
	 * Sets Request object.
	 *
	 * @param object $request
	 * @return void
	 */
	public function setRequest($request) {
		$this->request = $request;
	}

	/**
	 * Gets the parameters associated with certain method.
	 *
	 * @param string $method
	 * @return array or boolean
	 */
	public function getRequestParams($method) {
		return array_key_exists($method, $this->routes) ? $this->routes[$method] : false;
	}

	/**
	 * Creates the context object used in the request.
	 *
	 * @param string $type
	 * @param mixed  $arguments
	 * @return object
	 */
	public function createContext($type, $arguments = null) {
		return $this->request->$type($arguments);
	}

	/**
	 * Sends the request through the DataParser.
	 *
	 * @param string $url
	 * @param object $context
	 * @return object
	 */
	public function sendHttpRequest($url, $context = null) {
		return $this->data_parser->execute($url, $context);
	}
}
?>
