<?php

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

		if (in_array(false, $array)) return false;

		return true;
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
