<?php
class Http {
	public function execute($request) {
		$auth_token = $request->auth_token;
		$sid = $request->sid;
		$query = $this->buildQuery($request);

        $this->setMethod($request->type);
        $this->setHeader("Authorization: Basic " . base64_encode("$sid:$auth_token") .
			"Connection: close\r\n" .
			// This should not be here when PUT
			"Content-type: application/x-www-form-urlencoded" .
			"Content-length: " . strlen($query) . "\r\n");
		if ($query) {
			$this->setContent($query);
		}

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
	public function buildQuery($resource) {
		$array = array();
		foreach ($resource->attributes as $key => $value) {
			if ($value) $array[$key] = $value;
		}
		unset($array['id']);
		unset($array['created_at']);
		unset($array['updated_at']);
		return http_build_query($array);
	}

	public function buildContext($data) {
        return stream_context_create(array('http' => $data));
    }
}
?>
