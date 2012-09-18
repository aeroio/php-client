<?php
class StringHelper {
    /**
     * Private constructor, so the class can't be instantiated.
     *
     * @returns void
     */
    private function __construct() {}

    /**
     * Simple pluralization of a singular word.
     *
     * @params string $string
     * @returns string
     */
    public static function pluralize($string) {
        return $string . 's';
    }

    /**
     * Simple singularization of a plural word.
     *
     * @params string $string
     * @returns string
     */
    public static function singularize($string) {
        return substr_replace($string, "", -1);
    }
}
?>
