<?php
class TestHelper {
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
