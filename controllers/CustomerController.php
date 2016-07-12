<?php 
	
	class CustomerController {
		
		public function search() {
		
			// Require files
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Customer.php');
			
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
			
					// Initialize the Customer class
					$customer = new Customer($db);
			
					// Process user search
					$customer->selectAdvancedSearch($_POST['q']);
					if ($customer->errors) {
						$errors = $customer->errors;
						die(current($errors));
					} else {
						$results = $customer->records;
					}	
					
					// Set num_results to $results array value
					$num_results = count($results);
			
				}
			
			} else { // The form wasn't posted, get all records
			
				// Initialize the Customer class
				$customer = new Customer($db);
			
				// Get all records from the database
				$customer->selectAll($all);
				if ($customer->errors) {
					$errors = $customer->errors;
					die(current($errors));
				} else {
					$results = $customer->records;
				}	
			}
			
			// include view
			include_once('../views/customers/search.php');
			
		}	
		
		
		// CREATE FUNCTION
		
		public function insert() {
			
			// Include require classes
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Customer.php');
	
			// Initialize vars
			$vars = array();
			$errors = array();
	
			// Check if form was submitted
			if (isset($_POST['store_id']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['address_id']) && isset($_POST['active'])) { // Form posted
	
				// Validate input
				if (!strlen($_POST['store_id']))
					$errors['store_id'] = 'Please enter the store id number';
				if (!strlen($_POST['first_name']))
					$errors['first_name'] = 'Please enter the customer\'s first name';
				if (!strlen($_POST['last_name']))
					$errors['last_name'] = 'Please enter the customer\'s last name';
				if (!strlen($_POST['email']))
					$errors['email'] = 'Please enter the customer\'s email address';
				if (!strlen($_POST['address_id']))
					$errors['address_id'] = 'Please enter the address id';
				if (!strlen($_POST['active']))
					$errors['active'] = 'Please indicate if the customer is active';
	
				// Process insert
				if (!$errors) {
					$customer = new Customer(Database::connect());
					$customer->insert($_POST['store_id'], $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['address_id'], $_POST['active']);
					if ($customer->errors) {
						die('mysql error');
					}
				}
	
				// Show form errors or return success
				if ($errors) {
					$vars = array(
						'store_id' => htmlspecialchars($_POST['store_id'], ENT_QUOTES),
						'first_name' => htmlspecialchars($_POST['first_name'], ENT_QUOTES),
						'last_name' => htmlspecialchars($_POST['last_name'], ENT_QUOTES),
						'email' => htmlspecialchars($_POST['email'], ENT_QUOTES),
						'address_id' => htmlspecialchars($_POST['address_id'], ENT_QUOTES),
						'active' => htmlspecialchars($_POST['active'], ENT_QUOTES)
					);
					$endpoint = '/movies/public/customers/create';
					include_once('../views/customers/forms/customers.insert.form.php');
				} else { // no form errors
					$new_records = $customer->records;
					$store_id = htmlspecialchars($_POST['store_id'], ENT_QUOTES);
					$customer_name = htmlspecialchars($_POST['first_name'].' '.$_POST['last_name'], ENT_QUOTES);
					$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
					$address_id = htmlspecialchars($_POST['address_id'], ENT_QUOTES);
					$active = htmlspecialchars($_POST['active'], ENT_QUOTES);
					$customer_id = key($new_records);
					include_once('../views/customers/insert.success.php');
				}
	
			} else { // Form not posted
	
				$endpoint = '/movies/public/customers/create';
				include_once('../views/customers/forms/customers.insert.form.php');
	
			}
					
		}
		
		//READ FUNCTION
		
		public function read() {
			
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Customer.php');
			
			// Connect to database
			$db = Database::connect();
			
			$customer = new Customer($db);
			$customer->read($_GET['id']);
			if ($customer->errors) {
				$errors = $customer->errors;
				die(current($errors));
			} elseif (!$customer->records) {
				echo '<p>Sorry, we can\'t find the customer you\'re looking for</p>';
			} else {
				$record = current($customer->records);
				echo '<ul>';
				echo '<li>'.htmlspecialchars($record['store_id'], ENT_QUOTES).'</li>';
				echo '<li>'.htmlspecialchars($record['first_name'], ENT_QUOTES).' '.htmlspecialchars($record['last_name'], ENT_QUOTES).'</li>';
				echo '<li>'.htmlspecialchars($record['email'], ENT_QUOTES).'</li>';
				echo '<li>'.htmlspecialchars($record['address_id'], ENT_QUOTES).'</li>';
				echo '<li>'.htmlspecialchars($record['active'], ENT_QUOTES).'</li>';
				echo '</ul>';
			}
			
			// include view
			include_once('../views/customers/customers.read.php');
			
		}
		
		// UPDATE FUNCTION
		
		public function update() {
			
			// Include require classes
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Customer.php');
	
			// Check if id is valid
			$customer = new Customer(Database::connect());
			$customer->read($_GET['id']);
			if (!$customer->records) {
				echo 'not found';
				exit;
			}
	
			// Initialize vars
			$vars = array();
			$errors = array();
	
			// Check if form was submitted
			if (isset($_POST['store_id']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['address_id']) && isset($_POST['active'])) { // Form posted
	
				// Validate input
				if (!strlen($_POST['store_id']))
					$errors['store_id'] = 'Please enter the store id number';
				if (!strlen($_POST['first_name']))
					$errors['first_name'] = 'Please enter the customer\'s first name';
				if (!strlen($_POST['last_name']))
					$errors['last_name'] = 'Please enter the customer\'s last name';
				if (!strlen($_POST['email']))
					$errors['email'] = 'Please enter the customer\'s e-mail address';
				if (!strlen($_POST['address_id']))
					$errors['address_id'] = 'Please enter the address';
				if (!strlen($_POST['active']))
					$errors['active'] = 'Please indicate if the customer is active';
	
				// Process update
				if (!$errors) {
					$customer->update($_GET['id'], $_POST['store_id'], $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['address_id'], $_POST['active']);
					if ($customer->errors) {
						die('mysql error');
					}
				}
	
				// Show form errors or return success
				if ($errors) {
					$vars = array(
						'store_id' => htmlspecialchars($_POST['store_id'], ENT_QUOTES),
						'first_name' => htmlspecialchars($_POST['first_name'], ENT_QUOTES),
						'last_name' => htmlspecialchars($_POST['last_name'], ENT_QUOTES),
						'email' => htmlspecialchars($_POST['email'], ENT_QUOTES),
						'address_id' => htmlspecialchars($_POST['address_id'], ENT_QUOTES),
						'active' => htmlspecialchars($_POST['active'], ENT_QUOTES)
					);
					$endpoint = '/movies/public/customers/'.$_GET['id'].'/update';
					include_once('../views/customers/forms/customers.insert.form.php');
				} else { // no form errors
					$store_id = htmlspecialchars($_POST['store_id'], ENT_QUOTES);
					$customer_name = htmlspecialchars($_POST['first_name'].' '.$_POST['last_name'], ENT_QUOTES);
					$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
					$address_id = htmlspecialchars($_POST['address_id'], ENT_QUOTES);
					$active = htmlspecialchars($_POST['active'], ENT_QUOTES);
					$customer_id = $_GET['id'];
					include_once('../views/customers/insert.success.php');
				}
	
			} else { // Form not posted
	
				// Return the customer
				$records = $customer->records;
				$this_customer = current($records);
				$vars = array(
					'store_id' => htmlspecialchars($this_customer['store_id'], ENT_QUOTES),
					'first_name' => htmlspecialchars($this_customer['first_name'], ENT_QUOTES),
					'last_name' => htmlspecialchars($this_customer['last_name'], ENT_QUOTES),
					'email' => htmlspecialchars($this_customer['email'], ENT_QUOTES),
					'address_id' => htmlspecialchars($this_customer['address_id'], ENT_QUOTES),
					'active' => htmlspecialchars($this_customer['active'], ENT_QUOTES),
				);
				$endpoint = '/movies/public/customers/'.$this_customer['customer_id'].'/update';
				include_once('../views/customers/forms/customers.insert.form.php');
	
			}
			
		}
		
		// DELETE FUNCTION
		
		public function delete() {
			
			// Include require classes
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Customer.php');
	
			// Check if id is valid
			$customer = new Customer(Database::connect());
			$customer->read($_GET['id']);
			if (!$customer->records) {
				echo 'not found';
				exit;
			}
	
			// Initialize vars
			$vars = array();
			$errors = array();
	
			// Check if form was submitted
			if (isset($_POST['confirm'])) {
			
				$customer->delete($_GET['id']);
				if ($customer->errors) {
					die('mysql error');
					
				}
			
				//Return views
				include_once('../views/customers/delete.success.php');
			
			} else {
				
				$endpoint = '/movies/public/customers/'.$_GET['id'].'/delete';
				include_once('../views/customers/forms/customers.delete.form.php');
				
			}	
						
		}
		
	}
?>