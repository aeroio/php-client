<?php
class TestHelper {
    /**
     * Turns a column with values from the features into an array.
     *
     * @param object $data
     * @return array
     */
    public function columnToArray($data) {
        $values = $data->getRows();

        $array = array();

        foreach($values as $value) {
            $array[] = $value[0];
        }

        return $array;
    }
}
?>
