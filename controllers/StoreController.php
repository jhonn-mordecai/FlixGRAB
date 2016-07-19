<?php

class StoreController {

	public function search() {
		
		// Include classes
		require_once('../classes/Database.php');
		require_once('../classes/Model.php');
		require_once('../models/Store.php');

		// Get stores from db
		$store = new Store(Database::connect());
		$store->selectAll();
		if ($store->errors) {
			$sqlerrors = $store->errors;
			die('mysql error: '.current($sqlerrors));
		}

		// Return view
		$stores = $store->records;
		include_once('../views/stores/search.php');

	}

}

?>