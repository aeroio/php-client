<?php

/**
 * Aero_Request class.
 *
 * Assemble the request object with the provided data.
 */
class Aero_Request {

    /**
     * Used extension for the request.
     *
     * @var string
     */
    const EXT = '.json';

    /**
     * Request method.
     *
     * @var string
     */
    protected $method;

    /**
     * Request url.
     *
     * @var string
     */
    protected $url;

    /**
     * User auth_token.
     *
     * @var string
     */
    protected $auth_token;

    /**
     * User SID.
     *
     * @var string
     */
    protected $sid;

    /**
     * Record to be requested.
     *
     * @var object
     */
    protected $resource;

    /**
     * Assemble the request with the provided data.
     *
     * @param string $method
     * @param object $resource
     * @param array  $credentials
     * @param string $site
     * @return void
     */
    public function __construct($method, $resource, $credentials, $site) {
        $this->method = $method;
        $this->setCredentials($credentials);

        $this->assembleUrl($site, $resource);
        $this->resource = $resource;
    }


    /**
     * Get a certain property of this object.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
     * Set the credentials used for authorization.
     *
     * @param array $credentials
     * @return void
     */
    public function setCredentials($credentials) {
        foreach ($credentials as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Assemblate the url from the base site url, the path to the required
     * record and the used extension.
     *
     * @param string $site
     * @param object $resource
     * @return string
     */
    public function assembleUrl($site, $resource) {
        $this->url = $site . $resource->path() . self::EXT;
    }
}

?>
