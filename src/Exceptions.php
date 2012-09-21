<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

class ClientException extends Exception {}

class ServerException extends Exception {}

class ConnectionException extends Exception {}

class RedirectionException extends ConnectionException {}

class BadRequestException extends ClientException {}

class UnauthorizedException extends ClientException {}

class ForbiddenAccessException extends ClientException {}

class ResourceNotFoundException extends ClientException {}

class MethodNotAllowedException extends ClientException {}

class ResourceConflictException extends ClientException {}

class ResourceGoneException extends ClientException {}

class ResourceInvalidException extends ClientException {}

?>
