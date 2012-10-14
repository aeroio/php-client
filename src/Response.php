<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'Exceptions.php';

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

        switch ($code) {
            case 301:
                throw new RedirectionException('The data requested has been assigned new URI.');
            case 302:
                throw new RedirectionException('The data requested resides under differend URL.');
            case 303:
                throw new RedirectionException('Try another URL address or method.');
            case 307:
                throw new RedirectionException('The requested resource resides temporarily under a differend URI.');
            case ($code >= 200 && $code < 400):
                return self::reshape($result['response']);
            case 400:
                throw new BadRequestException('The request cannot be understood by the server due to malformed syntax.');
            case 401:
                throw new UnauthorizedException('The request requires user authentication.');
            case 403:
                throw new ForbiddenAccessException('The server understood the request, but is refusing to fulfill it.');
            case 404:
                throw new ResourceNotFoundException('The server has not found anything matching the Request-URI.');
            case 405:
                throw new MethodNotAllowedException('The method specified in the Request-Line is not allowed for this resource.');
            case 409:
                throw new ResourceConflictException('The request could not be completed due to a conflict with the current state of the resource.');
            case 410:
                throw new ResourceGoneException('The requested resource is no longer available at the server.');
            case 422:
                throw new ResourceInvalidException('The request was well formed, but was unable to be followed due to semantic errors.');
            case ($code >= 401 && $code <= 500):
                throw new ClientException('');
            case ($code >= 500 && $code <= 600):
                throw new ServerException('');
            default:
                throw new ConnectionException('');
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

            return trim($matches[0]);
        }
    }
}

?>
