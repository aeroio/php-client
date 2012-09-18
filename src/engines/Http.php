<?php
require_once 'Engine.php';

class Http implements Engine {
    /**
     * Assembles and executes the request.
     *
     * @params object $request
     * @returns object
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
     * @params string $url
     * @params resource $context
     * @returns object
     */
    public function fetch($url, $context) {
        return file_get_contents($url, false, $context);
    }

    /**
     * Gets the request method.
     *
     * @returns string
     */
    public function getMethod() {
        return $this->request['method'];
    }

    /**
     * Sets the request method.
     *
     * @params string $type
     */
    public function setMethod($type) {
        $this->request['method'] = strtoupper($type);
    }

    /**
     * Gets the request header.
     *
     * @returns string
     */
    public function getHeader() {
        return $this->request['header'];
    }

    /**
     * Sets the request header.
     *
     * @params string $data
     */
    public function setHeader($data) {
        $this->request['header'] = $data;
    }

    /**
     * Gets the request content.
     *
     * @returns string
     */
    public function getContent() {
        return $this->request['content'];
    }

    /**
     * Sets the request content.
     *
     * @params string $data
     */
    public function setContent($data) {
        $this->request['content'] = $data;
    }

    /**
     * Builds the http query used as content in the request.
     *
     * @params object $resource
     * @returns string
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
     * @params array $data
     * @returns response
     */
    public function buildContext($data) {
        return stream_context_create(array('http' => $data));
    }
}
?>
