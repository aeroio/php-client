<?php
class Http {
	public function execute($request) {
		$auth_token = $request->auth_token;
		$sid = $request->sid;

        $this->setMethod($request->type);
        $this->setHeader("Authorization: Basic " . base64_encode("$sid:$auth_token") .
                         "Connection: close\r\n");

        $context = $this->buildContext($this->request);

        return $this->fetch($request->url, $context);
	}

	public function fetch($url, $context) {
		return file_get_contents($url, false, $context);
	}

    public function getMethod() {
        return $this->request['method'];
    }

    public function setMethod($type) {
        $this->request['method'] = strtoupper($type);
    }

    public function getHeader() {
        return $this->request['header'];
    }

    public function setHeader($data) {
        $this->request['header'] = $data;
    }

    public function getContent() {
        return $this->request['content'];
    }

    public function setContent($data) {
        $this->request['content'] = $data;
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

	public function buildContext($data) {
        return stream_context_create(array('http' => $data));
    }
}
?>
