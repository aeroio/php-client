<?php

/**
 * TODO: add docs
 */
class Aero_Request {
    // TODO: FUCK, figure out why it WORKS??
    protected $type;
    protected $url;
    protected $auth_token;
    protected $sid;
    protected $resource;
    const ROOT_URL = 'http://localhost:3000/api/v1';
	const EXT = '.json';

    public function __construct($type, $resource, $credentials) {
        $this->type = $type;
        $this->setCredentials($credentials);

		$this->url = self::ROOT_URL . $resource->path() . self::EXT;
        $this->resource = $resource;
    }

	public function __get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}

    public function setCredentials($credentials) {
        foreach ($credentials as $key => $value) {
            $this->$key = $value;
        }
    }
}

?>
