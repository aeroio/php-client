<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'Engine.php';

/**
 * cURL engine.
 *
 * This engine executes the submited request using the cURL library.
 */
class Aero_Curl implements Engine {

    /**
     * The process to be executed.
     *
     * @var resource
     */
    protected $process;

    /**
     * Contructor, checking if the cURL library is installed.
     *
     * @return void
     */
    public function __construct() {
        if (!function_exists('curl_init')) {
            throw new CurlException('cURL not installed');
        }

        $this->process = $this->initialize();
    }

    /**
     * Assemble and execute the process.
     *
     * @param object $request
     * @return object
     */
    public function execute($request) {
        $this->createProcess($request);

        return $this->fetch($this->process);
    }

    /**
     * Create the whole process, which is to be executed.
     *
     * @param object $request
     * @return void
     */
    public function createProcess($request) {
        $sid = $request->getSid();
        $auth_token = $request->getAuthToken();

        $headers = array(
            "Authorization: Basic " . base64_encode("$sid:$auth_token")
        );

        $this->setOption(CURLOPT_URL, $request->getUrl());
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_HTTPHEADER, $headers);

        $attributes = $request->getResource()->toArray();

        switch($request->getMethod()) {
            case 'POST':
                $this->setOption(CURLOPT_POST, true);
                $this->setOption(CURLOPT_POSTFIELDS, $attributes);
                break;
            case 'PUT':
                $this->setOption(CURLOPT_CUSTOMREQUEST, "PUT");
                $this->setOption(CURLOPT_POSTFIELDS, $attributes);
                break;
            case 'DELETE':
                $this->setOption(CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                $this->setOption(CURLOPT_HTTPGET, true);
        }
    }

    /**
     * Initialize the main process.
     *
     * @return resource
     */
    public function initialize() {
        return curl_init();
    }

    /**
     * Execute and close the process.
     *
     * @param resource $process
     * @return object
     */
    public function fetch($process) {
        $array = array();

        $array['response'] = curl_exec($process);
        $array['header'] = $this->getInfo();

        curl_close($process);

        return $array;
    }

    /**
     * Get the process information.
     *
     * @param string $name
     * @return array
     */
    public function getInfo($name = null) {
        if ($name) return curl_getinfo($this->process, $name);

        return curl_getinfo($this->process);
    }

    /**
     * Set option to the process.
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function setOption($name, $value) {
        curl_setopt($this->process, $name, $value);
    }
}
?>
