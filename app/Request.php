<?php
class Request {

	/**
	 * Request parameters.
	 *
	 * @var array
	 */
	private $request = array();

	/**
	 * TODO
	 * No context needed for the GET request till this moment.
	 */
	public function get() {
		return true;
	}

	/**
	 * TODO
	 * No context needed for the POST request till this moment.
	 */
	public function post($params) {
		$query = $this->buildHttpQuery($params);

		$this->setMethod(__FUNCTION__);
		$this->setHeader("Connection: close\r\n" .
						 "Content-Length: " . strlen($query) . "\r\n");
		$this->setContent($query);

		$context = $this->buildContext($this->request);

		return $context;
	}

	/**
	 * TODO
	 * No context needed for the POST request till this moment.
	 */
	public function put($params) {
		$query = $this->buildHttpQuery($params);

		$this->setMethod(__FUNCTION__);
		$this->setHeader("Connection: close\r\n" .
						 "Content-Length: " . strlen($query) . "\r\n");
		$this->setContent($query);

		$context = $this->buildContext($this->request);

		return $context;
	}

	/**
	 * Gets the request method.
	 *
	 * @return string
	 */
	public function getMethod() {
		return $this->request['method'];
	}

	/**
	 * Sets the request method.
	 *
	 * @param string $type
	 * @return void
	 */
	public function setMethod($type) {
		$this->request['method'] = strtoupper($type);
	}

	/**
	 * Gets the used query.
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->request['content'];
	}

	/**
	 * Sets the used query.
	 *
	 * @param string $data
	 * @return void
	 */
	public function setContent($data) {
		$this->request['content'] = $data;
	}

	/**
	 * Gets the headers.
	 *
	 * @return string
	 */
	public function getHeader() {
		return $this->request['header'];
	}

	/**
	 * Sets the headers.
	 *
	 * @param string $data
	 * @return void
	 */
	public function setHeader($data) {
		$this->request['header'] = $data;
	}

	/**
	 * Build an HTTP query, after checking the supplied params for arrays of values.
	 *
	 * @param array $params
	 * @return array
	 */
	public function buildHttpQuery($params) {
		$multi = count(array_filter($params, 'is_array'));

		if ($multi > 0) {
			foreach ($params as $param) {
				if (is_array($param)) {
					return http_build_query($param);
				}
			}
		} else if (is_array($params[0])) {
			return http_build_query($params[0]);
		}
	}

	/**
	 * Build the request context.
	 *
	 * @param array $data
	 * @return array
	 */
	public function buildContext($data) {
		return stream_context_create(array('http' => $data));
	}
}
?>
