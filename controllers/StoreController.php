<?php 
	
	class StoreController {
		
		
		public function search() {

			// Require files
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Store.php');
			
			// Connect to database
			$db = Database::connect();
			
			// Initiate vars
			$all = "";
			$r = "";
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
					$movie = new Movie($db);
			
					// Process user search
					$movie->selectStoreInInventory($_POST['q']);
					if ($movie->errors) {
						$errors = $movie->errors;
						die(current($errors));
					} else {
						$results = $movie->records;
					}	
					
					// Set num_results to $results array value
					$num_results = count($results);
			
				}
			
			} else { // The form wasn't posted, get all records

				// Initialize the Store class
				$store = new Store($db);
			
				// Get all records from the database
				$store->selectAll($r->$_POST['q']);
				if ($store->errors) {
					$errors = $store->errors;
					die(current($errors));
				} else {
					$results = $store->records;
				}		
			
			}
			
			// include view
			include_once('../views/stores/search.php');

			
			
			
						
			/*
			// Initialize the Store class
			$store = new Store($db);
		
			// Get all records from the database
			$store->selectAll();
			if ($store->errors) {
				$errors = $store->errors;
				die(current($errors));
			} else {
				$results = $store->records;
			}	
			
			// include view
			include_once('../views/stores/search.php');*/
						
		}
		
		
	}
	
	
?>