<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

/**
 * Client side exceptions.
 */
class ClientException extends Exception {}

/**
 * Server side exceptions.
 */
class ServerException extends Exception {}

/**
 * Exceptions, when the connection has timed out or something uncaught happened.
 */
class ConnectionException extends Exception {}

/**
 * Exception, when new URI was assigned.
 */
class RedirectionException extends ConnectionException {}

/**
 * Exception, when the request cannot be understood by the server.
 */
class BadRequestException extends ClientException {}

/**
 * Exception, when user authentications is required.
 */
class UnauthorizedException extends ClientException {}

/**
 * Exception, when the server is refusing to fulfill the request.
 */
class ForbiddenAccessException extends ClientException {}

/**
 * Exception, when nothing mathing is found.
 */
class ResourceNotFoundException extends ClientException {}

/**
 * Exception, when the method type is not allowed.
 */
class MethodNotAllowedException extends ClientException {}

/**
 * Exception, when the request cannot be fulfiled due to a resource conflict.
 */
class ResourceConflictException extends ClientException {}

/**
 * Exception, when the resource is no longer available.
 */
class ResourceGoneException extends ClientException {}

/**
 * Exception, when there were semantic errors in the request.
 */
class ResourceInvalidException extends ClientException {}

?>
