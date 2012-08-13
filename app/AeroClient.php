<?php
require_once 'HttpRequest.php';
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
		'getProjects'   => array( 'type' => 'get'  , 'url' => '/v1/projects' ),
		'getProject'    => array( 'type' => 'get'  , 'url' => '/v1/project'  ),
		'createProject' => array( 'type' => 'post' , 'url' => '/v1/projects' ),
		'updateProject' => array( 'type' => 'put'  , 'url' => '/v1/project'  )
	);

	/**
	 * Constructor. Initializes dependencies objects.
	 *
	 * @return void
	 */
	public function __construct($auth_token = null, $sid = null) {
		$this->auth_token = $auth_token;
		$this->sid = $sid;

		$this->request = new HttpRequest();
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
			$context = $this->createContext($data['type'], $this->auth_token, $this->sid, $arguments);
			$url = $this->buildUrl($data['url'], $arguments);

			if ($context) {
				return $this->sendHttpRequest($url, $context);
			}
		} else {
			throw new Exception('Invalid Method');
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
	public function createContext($type, $auth_token, $sid, $arguments = null) {
		return $this->request->$type($auth_token, $sid, $arguments);
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

	/**
	 * Builds url for the request with the given arguments.
	 *
	 * @param string $url
	 * @param array  $arguments
	 * @return string
	 */
	public function buildUrl($url, $arguments) {
		if (is_array($arguments)) {
			foreach ($arguments as $argument) {
				if (is_numeric($argument)) {
					$url = $url . '/' . $argument;
				}
			}
		} else if (is_numeric($arguments)) {
			$url .= '/' . $arguments;
		} else {
			//nothing
		}

		return $url;
	}
}
?>
