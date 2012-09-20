<?php

/**
 * Aero_Response class.
 *
 * Handle the response, before returning it to the resource.
 */
class Aero_Response {

    /**
     * Handle the response, depending on its response code.
     *
     * @param array $result
     * @return array
     */
    public static function handle($result) {
        $code = self::responseCode($result['header']);

        switch($code) {
            case 301:
                throw new RedirectionException('This url redirects to another');
            case 302:
                throw new RedirectionException('This url redirects to another');
            case 303:
                throw new RedirectionException('This url redirects to another');
            case 307:
                throw new RedirectionException('This url redirects to another');
            case ($code >= 200 && $code < 400):
                return self::reshape($result['response']);
            case 400:
                throw new BadRequestException('');
            case 401:
                throw new UnauthorizedException('');
            case 403:
                throw new ForbiddenAccessException('');
            case 404:
                throw new ResourceNotFoundException('');
            case 405:
                throw new MethodNotAllowedException('');
            case 409:
                throw new ResourceConflictException('');
            case 410:
                throw new ResourceGoneException('');
            case 422:
                throw new ResourceInvalidException('');
            case ($code >= 401 && $code <= 500):
                throw new ClientError('');
            case ($code >= 500 && $code <= 600):
                throw new ServerError('');
            default:
                throw new ConnectionError('');
        }
    }

    /**
     * Turn the json response into its array alternative.
     *
     * @param string $response
     * @return array
     */
    public static function reshape($response) {
        $response = json_decode($response);

        if (is_array($response)) {
            $array = array();

            foreach($response as $project) {
                $array[] = get_object_vars($project);
            }

            return $array;
        }

        if (is_object($response)) {
            return get_object_vars($response);
        }
    }

    /**
     * Get the response code from the header.
     *
     * @param array $response
     * @return integer
     */
    public static function responseCode($response) {
        if (array_keys($response) !== range(0, count($response) - 1)) {
            return $response['http_code'];
        } else {
            preg_match('/\s+\d+\s+/', $response[0], $matches);

            return $matches[0];
        }
    }
}

?>
