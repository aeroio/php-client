<?php
class CurlRequest {
    /**
     * The curl process object.
     *
     * @var resourse
     */
    private $process;

    /**
     * Initializes the cURL process.
     *
     * @param string $url
     * @return void
     */
    public function __construct() {
        $this->setCurlProcess();
    }

    /**
     * Makes cURL GET request with the provided parameters.
     *
     * @param string $auth_token
     * @param string $sid
     * @param string $url
     * @return resourse
     */
    public function get($auth_token, $sid, $url) {
        $this->setOption(CURLOPT_URL, $url);
        $this->setOption(CURLOPT_HTTPHEADER, array("Authorization: Basic " . base64_encode("$auth_token:$sid")));
        $this->setOption(CURLOPT_RETURNTRANSFER, true);

        return $this->process;
    }

    /**
     * Makes cURL POST request with the provided parameters.
     *
     * @param string $auth_token
     * @param string $sid
     * @param string $url
     * @param array  $params
     * @return resourse
     */
    public function post($auth_token, $sid, $url, $params) {
        $body = $this->buildHttpQuery($params);

        $this->setOption(CURLOPT_URL, $url);
        $this->setOption(CURLOPT_POST, true);
        $this->setOption(CURLOPT_POSTFIELDS, $body);
        $this->setOption(CURLOPT_HTTPHEADER, array("Authorization: Basic " . base64_encode("$auth_token:$sid")));
        $this->setOption(CURLOPT_RETURNTRANSFER, true);

        return $this->process; 
    }

    /**
     * Makes cURL PUT request with the provided parameters.
     *
     * @param string $auth_token
     * @param string $sid
     * @param string $url
     * @param array  $params
     * @return resourse
     */
    public function put($auth_token, $sid, $url, $params) {
        $body = $this->buildHttpQuery($params);

        $this->setOption(CURLOPT_URL, $url);
        $this->setOption(CURLOPT_CUSTOMREQUEST, "PUT");
        $this->setOption(CURLOPT_POSTFIELDS, $body);
        $this->setOption(CURLOPT_HTTPHEADER, array("Authorization: Basic " . base64_encode("$auth_token:$sid")));
        $this->setOption(CURLOPT_RETURNTRANSFER, true);

        return $this->process;
    }

    /**
     * Makes cURL DELETErequest with the provided parameters.
     *
     * @param string $auth_token
     * @param string $sid
     * @param string $url
     * @return resourse
     */
    public function delete($auth_token, $sid, $url) {
        $this->setOption(CURLOPT_URL, $url);
        $this->setOption(CURLOPT_CUSTOMREQUEST, "DELETE");
        $this->setOption(CURLOPT_HTTPHEADER, array("Authorization: Basic " . base64_encode("$auth_token:$sid")));
        $this->setOption(CURLOPT_RETURNTRANSFER, true);

        return $this->process;
    }

    /**
     * Starts cURL process, which will be used for the request execution.
     *
     * @param string $url
     * @return void
     */
    public function setCurlProcess() {
        $this->process = curl_init();
    }

    /**
     * Gets the cURL process for this request.
     *
     * @return resourse
     */
    public function getCurlProcess() {
        return $this->process;
    }

    /**
     * Executes the cURL request.
     *
     * @return object
     */
    public function execute() {
        return curl_exec($this->process);
    }

    /**
     * Closes the cURL process used in this request.
     *
     * @return void
     */
    public function close() {
        curl_close($this->process);
    }

    /**
     * Sets certain option to the curl request with its associated value.
     *
     * @param string $name
     * @param mixed  $value
     * @return void
     */
    public function setOption($name, $value) {
        curl_setopt($this->process, $name, $value);
    }

    /**
     * Gets the value for certain option of the cURL request. If no option
     * is provided it returns all the values.
     *
     * @param string $name
     * @return mixed
     */
    public function getInfo($name = null) {
        if ($name) return curl_getinfo($this->process, $name);

        return curl_getinfo($this->process);
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
}
?>
