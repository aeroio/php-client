<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'Engine.php';

/**
 * Aero_Http class.
 *
 * Engine that uses the file_get_contents method. It should be used
 * when cURL is not available on the server.
 */
class Aero_Http implements Engine {

    /**
     * Options of the request.
     *
     * @var array
     */
    public $request = array();

    /**
     * Assemble and execute the request.
     *
     * @param object $request
     * @return object
     */
    public function execute($request) {
        $sid = $request->getSid();
        $auth_token = $request->getAuthToken();

        $query = $this->buildHttpQuery($request);

        $this->setMethod($request->getMethod());
        $this->setHeader("Authorization: Basic " . base64_encode("$sid:$auth_token") . "\r\n" .
            "Connection: close\r\n" .
            "Content-type: application/x-www-form-urlencoded\r\n" .
            "Content-length: " . strlen($query) . "\r\n");
        if ($query) {
            $this->setContent($query);
        }

        $context = $this->buildContext($this->request);

        return $this->fetch($request->getUrl(), $context);
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

        $attributes = $resource->getResource()->toArray();

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
