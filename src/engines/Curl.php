<?php
require_once 'Engine.php';

/**
 * TODO: add comment
 */
class Curl implements Engine {
    /**
     * The process to be executed.
     *
     * @var resource
     */
    protected $process;

    /**
     * Contructor, checking if the engine could work.
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
     * Assembles and executes the process.
     *
     * @param object $request
     * @return object
     */
    public function execute($request) {
        $this->createProcess($request);

        return $this->fetch($this->process);
    }

    /**
     * Creates the whole request, which is to be sent.
     *
     * @param object $request
     * @return void
     */
    public function createProcess($request) {
        $sid = $request->sid;
        $auth_token = $request->auth_token;

        $headers = array(
            "Authorization: Basic " . base64_encode("$sid:$auth_token")
        );

        $this->setOption(CURLOPT_URL, $request->url);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_HTTPHEADER, $headers);

        switch($request->type) {
            case 'POST':
                $this->setOption(CURLOPT_POST, true);
                $this->setOption(CURLOPT_POSTFIELDS, $request->attributes);
                break;
            case 'PUT':
                $this->setOption(CURLOPT_CUSTOMREQUEST, "PUT");
                $this->setOption(CURLOPT_POSTFIELDS, $request->attributes);
                break;
            case 'DELETE':
                $this->setOption(CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                $this->setOption(CURLOPT_HTTPGET, true);
        }
    }

    /**
     * Process initialization.
     *
     * @return resource
     */
    public function initialize() {
        return curl_init();
    }

    /**
     * Executes the process and fetches the data.
     *
     * @param resource $process
     * @return object
     */
    public function fetch($process) {
        $result = curl_exec($process);
		print_r($this->getInfo());

        curl_close($process);

        return $result;
    }

    /**
     * Gets the process information.
     *
     * @param string $name
     * @return array
     */
    public function getInfo($name = null) {
        if ($name) return curl_getinfo($this->process, $name);

        return curl_getinfo($this->process);
    }

    /**
     * Process options setter.
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
