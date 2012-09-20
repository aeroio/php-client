<?php

require_once 'Engine.php';

/**
 * TODO: prefix everything with aero :(
 *
 */
class Aero_Http implements Engine {

    /**
     * Assemble and execute the request.
     *
     * @param object $request
     * @return object
     */
    public function execute($request) {
        $sid = $request->sid;
        $auth_token = $request->auth_token;

        $query = $this->buildHttpQuery($request);

        $this->setMethod($request->method);
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
     * Fetch the data.
     *
     * @param string $url
     * @param resource $context
     * @return object
     */
    public function fetch($url, $context) {
        $array = array();

        $array['response'] = file_get_contents($url, false, $context);
        $array['header'] = $http_response_header;

        return $array;
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function getMethod() {
        return $this->request['method'];
    }

    /**
     * Set the request method.
     *
     * @param string $type
     */
    public function setMethod($type) {
        $this->request['method'] = strtoupper($type);
    }

    /**
     * Get the request header.
     *
     * @return string
     */
    public function getHeader() {
        return $this->request['header'];
    }

    /**
     * Set the request header.
     *
     * @param string $data
     */
    public function setHeader($data) {
        $this->request['header'] = $data;
    }

    /**
     * Get the request content.
     *
     * @return string
     */
    public function getContent() {
        return $this->request['content'];
    }

    /**
     * Set the request content.
     *
     * @param string $data
     */
    public function setContent($data) {
        $this->request['content'] = $data;
    }

    /**
     * Build the http query used as content in the request.
     *
     * @param object $resource
     * @return string
     */
    public function buildHttpQuery($resource) {
        $array = array();

        $attributes = $resource->resource->toArray();

        foreach ($attributes as $key => $value) {
            if ($value) $array[$key] = $value;
        }

        return http_build_query($array);
    }

    /**
     * Build the context for the request.
     *
     * @param array $data
     * @return response
     */
    public function buildContext($data) {
        return stream_context_create(array('http' => $data));
    }
}

?>
