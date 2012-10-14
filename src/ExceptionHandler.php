<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

require_once 'src/resources/Project.php';
require_once 'src/resources/Error.php';
require_once 'src/AeroIO.php';

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

//AeroIO::configure(array(
    //'site' => 'http://localhost:3000/api/v1',
    //'auth_token' => '52b8963d43b3f9081f58977b5aa3c110',
    //'sid' => '4ced755889ec99408be287e3ffb83b6b',
    //'project' => 56
//));

//AeroIO::handleExceptions();

//print_r(Aero_Error::all(array('project_id' => 56)));
//throw new Exception("And another error just like that", 20);
?>
