<?php 
	
	class RentalController {
		
		public function search() {
		
			// Require files
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Rental.php');
			
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
			
					// Initialize the Rental class
					$rental = new Rental($db);
			
					// Process user search
					$rental->selectBasicSearch($_POST['q']);
					if ($rental->errors) {
						$errors = $rental->errors;
						die(current($errors));
					} else {
						$results = $rental->records;
					}	
					
					// Set num_results to $results array value
					$num_results = count($results);
			
				}
			
			} else { // The form wasn't posted, get all records
			
				// Initialize the Rental class
				$rental = new Rental($db);
			
				// Get all records from the database
				$rental->selectAll($all);
				if ($rental->errors) {
					$errors = $rental->errors;
					die(current($errors));
				} else {
					$results = $rental->records;
				}	
			
			}
			
			// include view
			include_once('../views/rentals/search.php');
			
		}
		
		
		// CREATE FUNCTION
		
		public function insert() {
			
			// Include require classes
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Rental.php');
	
			// Initialize vars
			$vars = array();
			$errors = array();
	
			// Check if form was submitted
			if (isset($_POST['rental_date']) && isset($_POST['inventory_id']) && isset($_POST['customer_id']) && isset($_POST['return_date']) && isset($_POST['staff_id'])) { // Form posted
	
				// Validate input
				if (!strlen($_POST['rental_date']))
					$errors['rental_date'] = 'Please enter the rental date';
				if (!strlen($_POST['inventory_id']))
					$errors['inventory_id'] = 'Please enter the inventory id number';
				if (!strlen($_POST['customer_id']))
					$errors['customer_id'] = 'Please enter the customer id number';
				if (!strlen($_POST['return_date']))
					$errors['return_date'] = 'Please enter the return date';
				if (!strlen($_POST['staff_id']))
					$errors['staff_id'] = 'Please enter the staff id';
	
				// Process insert
				if (!$errors) {
					$rental = new Rental(Database::connect());
					$rental->insert($_POST['rental_date'], $_POST['inventory_id'], ($_POST['customer_id'], ($_POST['return_date'], ($_POST['staff_id']);
					if ($rental->errors) {
						die('mysql error');
					}
				}
	
				// Show form errors or return success
				if ($errors) {
					$vars = array(
						'rental_date' => htmlspecialchars($_POST['rental_date'], ENT_QUOTES),
						'inventory_id' => htmlspecialchars($_POST['inventory_id'], ENT_QUOTES),
						'customer_id' => htmlspecialchars($_POST['customer_id'], ENT_QUOTES),
						'return_date' => htmlspecialchars($_POST['return_date'], ENT_QUOTES),
						'staff_id' => htmlspecialchars($_POST['staff_id'], ENT_QUOTES)
					);
					$endpoint = '/movies/public/rentals/create';
					include_once('../views/rentals/forms/rentals.insert.form.php');
				} else { // no form errors
					$new_records = $rental->records;
					$rental_date = htmlspecialchars($_POST['rental_date'], ENT_QUOTES);
					$inventory_id = htmlspecialchars($_POST['inventory_id'], ENT_QUOTES);
					$customer_id = htmlspecialchars($_POST['customer_id'], ENT_QUOTES);
					$return_date = htmlspecialchars($_POST['return_date'], ENT_QUOTES);
					$staff_id = htmlspecialchars($_POST['staff_id'], ENT_QUOTES);
					$rental_id = key($new_records);
					include_once('../views/rentals/insert.success.php');
				}
	
			} else { // Form not posted
	
				$endpoint = '/movies/public/rentals/create';
				include_once('../views/rentals/forms/rentals.insert.form.php');
	
			}
					
		}
		
		
		
		//READ FUNCTION
		
		public function read() {
			
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Rental.php');
			
			// Connect to database
			$db = Database::connect();
			
			$rental = new Rental($db);
			$rental->read($_GET['id']);
			if ($rental->errors) {
				$errors = $rental->errors;
				die(current($errors));
			} elseif (!$rental->records) {
				echo '<p>Sorry, we can’t find the rental you’re looking for</p>';
			} else {
				$record = current($rental->records);
				echo '<ul>';
				echo '<li>'.htmlspecialchars($record['film_title'], ENT_QUOTES).'</li>';
				echo '<li>'.htmlspecialchars($record['customer_name'], ENT_QUOTES).'</li>';
				echo '<li>'.htmlspecialchars($record['staff_name'], ENT_QUOTES).'</li>';
				echo '<li>'.htmlspecialchars($record['payment_amount'], ENT_QUOTES).'</li>';
				echo '<li>'.htmlspecialchars($record['payment_date'], ENT_QUOTES).'</li>';
				echo '<li>'.htmlspecialchars($record['store_id'], ENT_QUOTES).'</li>';
				echo '</ul>';
			}
			
			// include view
			include_once('../views/rentals/search.php');
			
		}
		
		// UPDATE FUNCTION
		
		public function update() {
			
			// Include require classes
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Rental.php');
	
			// Check if id is valid
			$rental = new Rental(Database::connect());
			$rental->read($_GET['id']);
			if (!$rental->records) {
				echo 'not found';
				exit;
			}
	
			// Initialize vars
			$vars = array();
			$errors = array();
	
			if (isset($_POST['film_title']) && isset($_POST['customer_name']) && isset($_POST['staff_name']) && isset($_POST['payment_amount']) && isset($_POST['payment_date']) && isset($_POST['store_id'])) { // Form posted
	
				// Validate input
				if (!strlen($_POST['film_title']))
					$errors['film_title'] = 'Please enter a title';
				if (!strlen($_POST['customer_name']))
					$errors['customer_name'] = 'Please enter a customer name';
				if (!strlen($_POST['staff_name']))
					$errors['staff_name'] = 'Please enter a staff member\'s name';
				if (!strlen($_POST['payment_amount']))
					$errors['payment_amount'] = 'Please enter the payment amount';
				if (!strlen($_POST['payment_date']))
					$errors['payment_date'] = 'Please enter the payment date';
				if (!strlen($_POST['store_id']))
					$errors['store_id'] = 'Please enter the store id';
		
	
				// Process update
				if (!$errors) {
					$rental->update($_POST['film_title'], $_POST['customer_name'], $_POST['staff_name'], $_POST['payment_amount'], $_POST['payment_date'], $_POST['store_id']);
					if ($rental->errors) {
						die('mysql error');
					}
				}
	
				// Show form errors or return success
				if ($errors) {
					$vars = array(
						'film_title' => htmlspecialchars($_POST['film_title'], ENT_QUOTES),
						'customer_name' => htmlspecialchars($_POST['customer_name'], ENT_QUOTES),
						'staff_name' => htmlspecialchars($_POST['staff_name'], ENT_QUOTES),
						'payment_amount' => htmlspecialchars($_POST['payment_amount'], ENT_QUOTES),
						'payment_date' => htmlspecialchars($_POST['payment_date'], ENT_QUOTES),
						'store_id' => htmlspecialchars($_POST['store_id'], ENT_QUOTES)
					);
					$endpoint = '/movies/public/rentals/'.$_GET['id'].'/update';
					include_once('../views/rentals/forms/rentals.insert.form.php');
				} else { // no form errors
					$film_title = htmlspecialchars($_POST['film_title'], ENT_QUOTES);
					$customer_name = htmlspecialchars($_POST['customer_name'], ENT_QUOTES);
					$staff_name = htmlspecialchars($_POST['staff_name'], ENT_QUOTES);
					$payment_amount = htmlspecialchars($_POST['payment_amount'], ENT_QUOTES);
					$payment_date = htmlspecialchars($_POST['payment_date'], ENT_QUOTES);
					$store_id = htmlspecialchars($_POST['store_id'], ENT_QUOTES);
					$rental_id = $_GET['id'];
					include_once('../views/rentals/insert.success.php');
				}
	
			} else { // Form not posted
	
				// Return the movie
				$records = $rental->records;
				$this_rental = current($records);
				$vars = array(
					'film_title' => htmlspecialchars($this_rental['film_title'], ENT_QUOTES),
					'customer_name' => htmlspecialchars($this_rental['customer_name'], ENT_QUOTES),
					'staff_name' => htmlspecialchars($this_rental['staff_name'], ENT_QUOTES),
					'payment_amount' => htmlspecialchars($this_rental['payment_amount'], ENT_QUOTES),
					'payment_date' => htmlspecialchars($this_rental['payment_date'], ENT_QUOTES),
					'store_id' => htmlspecialchars($this_rental['store_id'], ENT_QUOTES)
				);
				$endpoint = '/movies/public/rentals/'.$this_rental['rental_id'].'/update';
				include_once('../views/rentals/forms/rentals.insert.form.php');
	
			}
			
		}
		
		// DELETE FUNCTION
		
		public function delete() {
			
			// Include require classes
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Rental.php');
	
			// Check if id is valid
			$rental = new Rental(Database::connect());
			$rental->read($_GET['id']);
			if (!$rental->records) {
				echo 'not found';
				exit;
			}
	
			// Initialize vars
			$vars = array();
			$errors = array();
	
			// Check if form was submitted
			if (isset($_POST['confirm'])) {
			
				$rental->delete($_GET['id']);
				if ($rental->errors) {
					die('mysql error');
					
				}
			
				//Return views
				include_once('../views/rentals/delete.success.php');
			
			} else {
				
				$endpoint = '/movies/public/rentals/'.$_GET['id'].'/delete';
				include_once('../views/rentals/forms/rentals.delete.form.php');
				
			}	
						
		}
	
	}	

?>