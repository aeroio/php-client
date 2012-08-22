<?php
class Aero_Request {
	public function __construct(Array $attributes = null) {
		if ($attributes) {
			foreach ($attributes as $attribute => $value) {
				$this->$attribute = $value;
			}
		}
	}
}
?>
