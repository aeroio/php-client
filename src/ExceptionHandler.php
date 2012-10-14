<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/resources/Error.php';

/**
 * Aero_ExceptionHandler class.
 *
 * Set up the handling of errors for certain project.
 */
class Aero_ExceptionHandler {

    /**
     * Id of the project to be handled.
     *
     * @var integer
     */
    public static $project_id;

    /**
     * Save an error belonging to certain project.
     *
     * @param object $exception
     * @return void
     */
    public function handle($exception) {
        $params = array(
            'project_id' => self::$project_id,
            'message' => $exception->getMessage(),
            'resolved' => false
        );

        $error = new Aero_Error($params);
        $error->save();
    }

    /**
     * Set exception handler for certain project.
     *
     * @param integer $id
     * @return void
     */
    public static function for_project($id) {
        self::$project_id = $id;

        set_exception_handler(array(get_called_class(), "handle"));
    }
}

?>
