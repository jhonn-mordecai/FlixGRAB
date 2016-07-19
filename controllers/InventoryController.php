<?php

class InventoryController {

	public function search() {

		// Require classes
		require_once('../classes/Database.php');
		require_once('../classes/Model.php');
		require_once('../models/Store.php');
		require_once('../models/Inventory.php');

		// Check if the passed store id exists
		$store = new Store(Database::connect());
		$store->read($_GET['store']);
		if ($store->errors) {
			$sqlerrors = $store->errors;
			die('MySQL error: '.current($sqlerrors));
		}
		if (!$store->records) {
			die('store does not exist');
		}
		// Decide if we want in-stock or not in stock
			$in_stock = isset($_GET['out']) ? false : true;
		
		// Connect to database
		$db = Database::connect();
		
		// Initiate vars
		$all = "";
		$q = "";
		$posted = false;
		$results = array();
		$num_results = 0;
		
		// Check if form was posted
		if (isset($_POST['q'])) {
		
			// Set posted as true
			$posted = true;
		
			// Check if q is valid
			if (isset($_POST['q']) && $_POST['q']) { // q is valid
		
				// Store the search query
				$q = $_POST['q'];
		
				// Initialize the Inventory class
				$inventory = new Inventory($db);
		
				// Process user search
				$inventory->basicSearch($_POST['q']);
				if ($inventory->errors) {
					$errors = $inventory->errors;
					die(current($errors));
				} else {
					$results = $inventory->records;
				}	
				
				// Set num_results to $results array value
				$num_results = count($results);
		
			}
		
		} else {

			
	
			// Get films that are in inventory at the passed store
			$inventory = new Inventory(Database::connect());
			if ($in_stock)
				$inventory->selectStoreInInventory($_GET['store']);
			else
				$inventory->selectStoreNotInInventory($_GET['store']);
			if ($inventory->errors) {
				$sqlerrors = $inventory->errors;
				die('MySQL error: '.current($sqlerrors));
			}
		
		}

		// Return view
		$store_id = $_GET['store'];
		$store_records = $store->records;
		$this_store = current($store_records);
		$store_location = htmlspecialchars($this_store['address'].', '.$this_store['city'].', '.$this_store['country'], ENT_QUOTES);
		$records = $inventory->records;
		include_once('../views/inventory/search.php');

	}
	
	

	public function create() {
	
		// Require classes
		require_once('../classes/Database.php');
		require_once('../classes/Model.php');
		require_once('../models/Store.php');
		require_once('../models/Movie.php');
		require_once('../models/Inventory.php');

		// Check if correct vars were passed
		if (!isset($_GET['store']) || !isset($_GET['movie']))
			die('bad request');

		// Validate store
		$store = new Store(Database::connect());
		$store->read($_GET['store']);
		if ($store->errors) {
			$sqlerrors = $store->errors;
			trigger_error(current($sqlerrors), E_USER_ERROR);
		}
		if (!$store->records)
			die('store not found');

		// Validate film
		$movie = new Movie(Database::connect());
		$movie->read($_GET['movie']);
		if ($movie->errors) {
			$sqlerrors = $movie->errors;
			trigger_error(current($sqlerrors), E_USER_ERROR);
		}
		if (!$movie->records)
			die('film not found');

		// Create inventory item
		$inventory = new Inventory(Database::connect());
		$inventory->insert($_GET['movie'], $_GET['store']);
		if ($inventory->errors) {
			$sqlerrors = $inventory->errors;
			die('mysql error: '.current($sqlerrors));
		}

		// Return success
		$store_id = $_GET['store'];
		include_once('../views/inventory/inventory.insert.success.php');

	}

	public function delete() {
		
		// Require classes
		require_once('../classes/Database.php');
		require_once('../classes/Model.php');
		require_once('../models/Inventory.php');

		// Validate inventory item
		$inventory = new Inventory(Database::connect());
		$inventory->read($_GET['id']);
		if ($inventory->errors) {
			$sqlerrors = $inventory->errors;
			trigger_error(current($sqlerrors), E_USER_ERROR);
		}
		if (!$inventory->records)
			die('inventory item not found');
		else
			$inventory_records = $inventory->records;
		
		// Delete from inventory
		$inventory->delete($_GET['id']);
		if ($inventory->errors) {
			$sqlerrors = $inventory->errors;
			trigger_error(current($sqlerrors), E_USER_ERROR);
		}

		// Return success
		$this_inventory = current($inventory_records);
		$store_id = $this_inventory['store_id'];
		include_once('../views/inventory/inventory.delete.success.php');

	}

}

?>