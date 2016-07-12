<?php 
	
	class InventoryController {
		
		public function search() {
		
			// Require files
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Inventory.php');
			
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
					$inventory->selectBasicSearch($_POST['q']);
					if ($inventory->errors) {
						$errors = $inventory->errors;
						die(current($errors));
					} else {
						$results = $inventory->records;
					}	
					
					// Set num_results to $results array value
					$num_results = count($results);
			
				}
			
			} else { // The form wasn't posted, get all records
			
				// Initialize the Inventory class
				$inventory = new Inventory($db);
			
				// Get all records from the database
				$inventory->selectAll($all);
				if ($inventory->errors) {
					$errors = $inventory->errors;
					die(current($errors));
				} else {
					$results = $inventory->records;
				}	
			
			}
			
			// include view
			include_once('../views/inventory/search.php');
			
		}	
		
		// CREATE FUNCTION
		
		public function insert() {
			
			// Include require classes
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Inventory.php');
	
			// Initialize vars
			$vars = array();
			$errors = array();
	
			// Check if form was submitted
			if (isset($_POST['film_id']) && isset($_POST['store_id'])) { // Form posted
	
				// Validate input
				if (!strlen($_POST['film_id']))
					$errors['film_id'] = 'Please enter a film id number';
				if (!strlen($_POST['store_id']))
					$errors['store_id'] = 'Please enter a store id number';
	
				// Process insert
				if (!$errors) {
					$inventory = new Inventory(Database::connect());
					$inventory->insert($_POST['film_id'], $_POST['store_id']);
					if ($inventory->errors) {
						die('mysql error');
					}
				}
	
				// Show form errors or return success
				if ($errors) {
					$vars = array(
						'film_id' => htmlspecialchars($_POST['film_id'], ENT_QUOTES),
						'store_id' => htmlspecialchars($_POST['store_id'], ENT_QUOTES)
					);
					$endpoint = '/movies/public/inventory/create';
					include_once('../views/inventory/forms/inventory.insert.form.php');
				} else { // no form errors
					$new_records = $inventory->records;
					$film_id = htmlspecialchars($_POST['film_id'], ENT_QUOTES);
					$store_id = htmlspecialchars($_POST['store_id'], ENT_QUOTES);
					$inventory_id = key($new_records);
					include_once('../views/inventory/insert.success.php');
				}
	
			} else { // Form not posted
	
				$endpoint = '/movies/public/inventory/create';
				include_once('../views/inventory/forms/inventory.insert.form.php');
	
			}
					
		}
		
		
		//READ FUNCTION
		
		public function read() {
			
			// Require files
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Inventory.php');
			
			// Connect to database
			$db = Database::connect();
			
			$inventory = new Inventory($db);
			$inventory->read($_GET['id']);
			if ($inventory->errors) {
				$errors = $inventory->errors;
				die(current($errors));
			} elseif (!$inventory->records) {
				echo '<p>Sorry, we can’t find the item you’re looking for</p>';
			} else {
				$record = current($inventory->records);
				echo '<ul>';
				echo '<li>'.htmlspecialchars($record['inventory_id'], ENT_QUOTES).'</li>';
				echo '<li>'.htmlspecialchars($record['film_title'], ENT_QUOTES).'</li>';
				echo '</ul>';
			}
			
			// include view
			include_once('../views/inventory/search.php');
			
		}
		
		
		
		// UPDATE FUNCTION
		
		public function update() {
			
			// Include require classes
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Inventory.php');
	
			// Check if id is valid
			$inventory = new Inventory(Database::connect());
			$inventory->read($_GET['id']);
			if (!$inventory->records) {
				echo 'not found';
				exit;
			}
	
			// Initialize vars
			$vars = array();
			$errors = array();
	
			// Check if form was submitted
			if (isset($_POST['film_id']) && isset($_POST['store_id'])) { // Form posted
	
				// Validate input
				if (!strlen($_POST['film_id']))
					$errors['film_id'] = 'Please enter a film id';
				if (!strlen($_POST['store_id']))
					$errors['store_id'] = 'Please enter a store id';
	
				// Process update
				if (!$errors) {
					$inventory->update($_GET['id'], $_POST['film_id'], $_POST['store_id']);
					if ($actor->errors) {
						die('mysql error');
					}
				}
	
				// Show form errors or return success
				if ($errors) {
					$vars = array(
						'film_id' => htmlspecialchars($_POST['film_id'], ENT_QUOTES),
						'store_id' => htmlspecialchars($_POST['store_id'], ENT_QUOTES)
					);
					$endpoint = '/movies/public/inventory/'.$_GET['id'].'/update';
					include_once('../views/inventory/forms/inventory.insert.form.php');
				} else { // no form errors
					$film_id = htmlspecialchars($_POST['film_id'], ENT_QUOTES);
					$store_id = htmlspecialchars($_POST['store_id'], ENT_QUOTES);
					$inventory_id = $_GET['id'];
					include_once('../views/inventory/insert.success.php');
				}
	
			} else { // Form not posted
	
				// Return the actor
				$records = $inventory->records;
				$this_inventory = current($records);
				$vars = array(
					'film_id' => htmlspecialchars($this_inventory['film_id'], ENT_QUOTES),
					'store_id' => htmlspecialchars($this_inventory['store_id'], ENT_QUOTES)
				);
				$endpoint = '/movies/public/inventory/'.$this_inventory['inventory_id'].'/update';
				include_once('../views/inventory/forms/inventory.insert.form.php');
	
			}
			
		}
		
		// DELETE FUNCTION
		
		public function delete() {
			
			// Include require classes
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Inventory.php');
	
			// Check if id is valid
			$inventory = new Inventory(Database::connect());
			$invenetory->read($_GET['id']);
			if (!$inventory->records) {
				echo 'not found';
				exit;
			}
	
			// Initialize vars
			$vars = array();
			$errors = array();
	
			// Check if form was submitted
			if (isset($_POST['confirm'])) {
			
				$inventory->delete($_GET['id']);
				if ($inventory->errors) {
					die('mysql error');
					
				}
			
				//Return views
				include_once('../views/inventory/delete.success.php');
			
			} else {
				
				$endpoint = '/movies/public/inventory/'.$_GET['id'].'/delete';
				include_once('../views/inventory/forms/inventory.delete.form.php');
				
			}
						
		}

		
		
	}
?>