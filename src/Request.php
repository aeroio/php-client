<?php

/**
 * TODO: add docs
 */
class Aero_Request {
    //public function __construct(Array $attributes = null) {
        //if ($attributes) {
            //foreach ($attributes as $attribute => $value) {
                //$this->$attribute = $value;
            //}
        //}
    //}

    // TODO: FUCK, figure out why it WORKS??
    protected $type;
    protected $url;
    protected $auth_token;
    protected $sid;
    protected $resource;

    public function __construct($type, $resource, $credentials) {
        $this->type = $type;
        $this->setCredentials($credentials);
        $this->url = UrlBuilder::assemble($resource);
        $this->resource = $resource;
    }

    public function setCredentials($credentials) {
        foreach ($credentials as $key => $value) {
            $this->$key = $value;
        }
    }
}

?>
