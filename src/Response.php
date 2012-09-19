<?php
// TODO: add comment
class Aero_Response {
    public static function handle($response) {
        // TODO: handle server side errors
        // https://github.com/rails/activeresource/blob/master/lib/active_resource/connection.rb#L129
        $result = json_decode($response);

        if (is_array($result)) {
            $array = array();

            foreach($result as $project) {
                $array[] = get_object_vars($project);
            }

            return $array;
        }

        if (is_object($result)) {
            return get_object_vars($result);
        }
    }
}
?>
