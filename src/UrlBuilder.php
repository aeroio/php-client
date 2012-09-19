<?php
require_once 'src/helpers/StringHelper.php';

class UrlBuilder {

    /**
     * Root url for the application.
     *
     * @var const
     */
    const ROOT_URL = 'http://localhost:3000/api/v1';

    // TODO: move ot resource
    const EXTENSION = '.json'

    /**
     * Private constructor, so the class can't be instantiated.
     *
     * @returns void
     */
    private function __construct() {}

    private function __clone()

    /**
     * Assembles the url with the provided resource data and format.
     *
     * @params object $resource
     * @params string $format
     * @returns string
     */
    public static function assemble($resource, $format = 'json') {
        $url = self::ROOT_URL;

        $url .= static::add_parent($resource);
        $url .= static::add_current($resource);

        return $url .= ".$format";
    }

    /**
     * Turns the parent attributes into url string.
     *
     * @params object $resource
     * @returns string
     */
    public static function add_parent($resource) {
        $attributes = get_object_vars($resource);

        foreach ($attributes as $key => $value) {
            $parent = strstr($key, '_id', true);

            if ($parent) {
                $parents = StringHelper::pluralize($parent);
                return "/$parents/$value";
            }
        }
    }

    /**
     * Turns the current resource attributes into url.
     *
     * @params object $resource
     * @returns string
     */
    public static function add_current($resource) {
        $name = strtolower(get_class($resource));
        $name = end(explode('_', $name));
        $name = StringHelper::pluralize($name);

        if ($resource->id) return "/$name/$resource->id";

        return "/$name";
    }
}
?>
