<?php
class HttpRequest {

    /**
     * Request parameters.
     *
     * @var array
     */
    private $request = array();

    /**
     * Build the Http context for GET request.
     *
     * @param string $auth_token
     * @param string $sid
     * @return resourse
     */
    public function get($auth_token, $sid) {
        $this->setMethod(__FUNCTION__);
        $this->setHeader("Authorization: Basic " . base64_encode("$auth_token:$sid"));

        $context = $this->buildContext($this->request);

        return $context;
    }

    /**
     * Build the Http context for POST request.
     *
     * @param string @auth_token
     * @param string @sid
     * @param array  @params
     * @return resourse
     */
    public function post($auth_token, $sid, $params) {
        $query = $this->buildHttpQuery($params);

        $this->setMethod(__FUNCTION__);
        $this->setHeader("Authorization: Basic " . base64_encode("$auth_token:$sid") .
                         "Connection: close\r\n" .
                         "Content-Length: " . strlen($query) . "\r\n");
        $this->setContent($query);

        $context = $this->buildContext($this->request);

        return $context;
    }

    /**
     * Build the Http context for the PUT request.
     *
     * @param string @auth_token
     * @param string @sid
     * @param array  @params
     * @return resourse
     */
    public function put($auth_token, $sid, $params) {
        $query = $this->buildHttpQuery($params);

        $this->setMethod(__FUNCTION__);
        $this->setHeader("Authorization: Basic " . base64_encode("$auth_token:$sid") .
                         "Connection: close\r\n" .
                         "Content-Length: " . strlen($query) . "\r\n");
        $this->setContent($query);

        $context = $this->buildContext($this->request);

        return $context;
    }

    /**
     * Build the Http context for the DELETE request.
     *
     * @param string @auth_token
     * @param string @sid
     * @param array  @params
     * @return resourse
     */
    public function delete($auth_token, $sid, $params) {
        $query = $this->buildHttpQuery($params);

        $this->setMethod(__FUNCTION__);
        $this->setHeader("Authorization: Basic " . base64_encode("$auth_token:$sid") .
                         "Connection: close\r\n" .
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
