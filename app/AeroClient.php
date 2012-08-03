<?php
require_once 'Request.php';
require_once 'DataParser.php';

class AeroClient {
	private $request;
	private $data_parser;

	public function __construct() {
		$this->request = new Request();
		$this->data_parser = new DataParser();
	}

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

	public function getDataParser() {
		return $this->data_parser;
	}

	public function setDataParser($data_parser) {
		$this->data_parser = $data_parser;
	}

	public function getRequest() {
		return $this->request;
	}

	public function setRequest($request) {
		$this->request = $request;
	}

	public function getRequestParams($method) {
		return array_key_exists($method, $this->routes) ? $this->routes[$method] : false;
	}

	public function createContext($type, $arguments = null) {
		return $this->request->$type($arguments);
	}

	public function sendHttpRequest($url, $context = null) {
		return $this->data_parser->execute($url, $context);
	}

	private $routes = array(
		'getProjects' => array('type' => 'get', 'url' => '/v1/projects')
	);
}
?>
