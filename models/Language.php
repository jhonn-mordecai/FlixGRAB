<?php

class Language extends Model {

	public function selectAll() {
		$q = "SELECT * FROM language";
		$this->process($q);
	}

}

?>