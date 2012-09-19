<?php
class Validator {
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

        $valid = true;

        foreach ($resource->validate as $attribute => $rule) {
            foreach($rule as $name => $value) {
                $valid = self::$name($attribute, $value);
            }
        }

        return $valid;
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

    /**
     * Checks if certain attributes is in defined maximum range.
     *
     * @params string $attribute
     * @params boolean $value
     * @returns boolean
     */
    public static function max_length($attribute, $value) {
        return strlen(self::$resource->$attribute) <= $value;
    }

    /**
     * Checks if certain attributes is in defined minimum range.
     *
     * @params string $attribute
     * @params boolean $value
     * @returns boolean
     */
    public static function min_length($attribute, $value) {
        return strlen(self::$resource->$attribute) >= $value;
    }
}
?>
