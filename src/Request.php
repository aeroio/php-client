<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

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
     * Get the SID used for the authorization.
     *
     * @return string
     */
    public function getSid() {
        return $this->sid;
    }

    /**
     * Get the auth token used for the authentication.
     *
     * @return string
     */
    public function getAuthToken() {
        return $this->auth_token;
    }

    /**
     * Get the type of method used for the request.
     *
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Get the URL address for the request.
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Get the resource, for which the request will be executed for.
     *
     * @return object
     */
    public function getResource() {
        return $this->resource;
    }

    /**
     * Assemble the url from the base site url, the path to the required
     * record and the used extension.
     *
     * @param string $site
     * @param object $resource
     * @return string
     */
    public function assembleUrl($site, $resource) {
        $this->url = $site . $resource->path() . self::EXT;
    }

    /**
     * Set the credentials used for authorization.
     *
     * @param array $credentials
     * @return void
     */
    protected function setCredentials($credentials) {
        foreach ($credentials as $key => $value) {
            $this->$key = $value;
        }
    }
}

?>
