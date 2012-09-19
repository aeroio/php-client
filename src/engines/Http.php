<?php
require_once 'Engine.php';

/**
 * TODO: prefix everything with aero :(
 *
 */
class Http implements Engine {
    /**
     * Assembles and executes the request.
     *
     * @param object $request
     * @return object
     */
    public function execute($request) {
        $sid = $request->sid;
        $auth_token = $request->auth_token;

        $query = $this->buildHttpQuery($request);

        $this->setMethod($request->type);
        $this->setHeader("Authorization: Basic " . base64_encode("$sid:$auth_token") . "\r\n" .
            "Connection: close\r\n" .
            "Content-type: application/x-www-form-urlencoded\r\n" .
            "Content-length: " . strlen($query) . "\r\n");
        if ($query) {
            $this->setContent($query);
        }

        $context = $this->buildContext($this->request);

        return $this->fetch($request->url, $context);
    }

    /**
     * Fetches the data.
     *
     * @param string $url
     * @param resource $context
     * @return object
     */
    public function fetch($url, $context) {
        $response = file_get_contents($url, false, $context);

		print_r($http_response_header);
		return $response;
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
     */
    public function setMethod($type) {
        $this->request['method'] = strtoupper($type);
    }

    /**
     * Gets the request header.
     *
     * @return string
     */
    public function getHeader() {
        return $this->request['header'];
    }

    /**
     * Sets the request header.
     *
     * @param string $data
     */
    public function setHeader($data) {
        $this->request['header'] = $data;
    }

    /**
     * Gets the request content.
     *
     * @return string
     */
    public function getContent() {
        return $this->request['content'];
    }

    /**
     * Sets the request content.
     *
     * @param string $data
     */
    public function setContent($data) {
        $this->request['content'] = $data;
    }

    /**
     * Builds the http query used as content in the request.
     *
     * @param object $resource
     * @return string
     */
    public function buildHttpQuery($resource) {
        $array = array();

        foreach ($resource->attributes as $key => $value) {
            if ($value) $array[$key] = $value;
        }

        return http_build_query($array);
    }

    /**
     * Builds the context for the request.
     *
     * @param array $data
     * @return response
     */
    public function buildContext($data) {
        return stream_context_create(array('http' => $data));
    }
}
?>
