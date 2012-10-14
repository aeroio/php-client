<?php

/**
 * Aero.io API client for PHP
 *
 * @copyright Copyright 2012, aero.io (http://aero.io)
 * @license The MIT License
 */

/**
 * Aero_Validator class.
 *
 * Validate the resource.
 */
class Aero_Validator {

    /**
     * Holder for the object to be validated.
     *
     * @var object
     */
    public static $resource;

    /**
     * Checks if the validations rules apply.
     *
     * @params object $resource
     * @returns boolean
     */
    public static function is_valid($resource) {
        self::$resource = $resource;

        $array = array();

        foreach ($resource->validate as $attribute => $rule) {
            foreach($rule as $name => $value) {
                $array[] = self::$name($attribute, $value);
            }
        }

        return !in_array(false, $array);
    }

    /**
     * Checks if certain attributes is present.
     *
     * @params string $attribute
     * @params boolean $value
     * @returns boolean
     */
    public static function presence($attribute, $value) {
        return isset(self::$resource->$attribute) == true;
    }
}

?>
