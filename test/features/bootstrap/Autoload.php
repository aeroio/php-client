<?php
class Autoload {
    public static function execute($path, $pattern = null) {
        $files = scandir($path);

        $array = array();

        foreach ($files as $file) {
            if (!!preg_match('/' . $pattern . '/', $file)) {
                array_push($array, $path . $file);
            }
        }

        return $array;
    }
}
?>
