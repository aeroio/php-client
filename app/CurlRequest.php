<?php
class CurlRequest {
    private $process;

    public function __construct($url = null) {
        $this->setCurlProcess($url);
    }

    public function get($auth_token, $sid, $url) {
        $this->setOption(CURLOPT_HTTPHEADER, array("Authorization: Basic " . base64_encode("$auth_token:$sid")));
        $this->setOption(CURLOPT_RETURNTRANSFER, true);

		return $this->process;
    }

    public function post($auth_token, $sid, $url, $params) {
        $body = $this->buildHttpQuery($params);

        $this->setOption(CURLOPT_POST, true);
        $this->setOption(CURLOPT_POSTFIELDS, $body);
        $this->setOption(CURLOPT_HTTPHEADER, array("Authorization: Basic " . base64_encode("$auth_token:$sid")));
        $this->setOption(CURLOPT_RETURNTRANSFER, true);

		return $this->process; 
    }

    public function put($auth_token, $sid, $url, $params) {
        $body = $this->buildHttpQuery($params);

        $this->setOption(CURLOPT_CUSTOMREQUEST, "PUT");
        $this->setOption(CURLOPT_POSTFIELDS, $body);
        $this->setOption(CURLOPT_HTTPHEADER, array("Authorization: Basic " . base64_encode("$auth_token:$sid")));
        $this->setOption(CURLOPT_RETURNTRANSFER, true);

        return $this->process;
    }

    public function setCurlProcess($url) {
        return $this->process = curl_init($url);
    }

    public function getCurlProcess() {
        return $this->process;
    }

    public function execute() {
        return curl_exec($this->process);
    }

    public function close() {
        curl_close($this->process);
    }

    public function setOption($name, $value) {
        curl_setopt($this->process, $name, $value);
    }

    public function getInfo($name = null) {
        if ($name) return curl_getinfo($this->process, $name);

        return curl_getinfo($this->process);
    }

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
