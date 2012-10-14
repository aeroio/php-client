<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/ExceptionHandler.php';

class ExceptionHandlerTest extends PHPUnit_Framework_TestCase {
	public function testHandler() {
		throw new Exception("Catch me", 2);
	}
}

?>
