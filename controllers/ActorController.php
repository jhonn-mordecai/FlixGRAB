<?php


class ActorController {

	// SEARCH METHOD
	
	public function search() {

		// Require classes
		require_once('../classes/Database.php');
		require_once('../classes/Model.php');
		require_once('../models/Actor.php');

		// Connect to database
		$db = Database::connect();

		// Initiate vars
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

				// Initialize the Actor class
				$actor = new Actor($db);

				// Process user search
				$actor->selectAdvancedSearch($_POST['q']);
				if ($actor->errors) {
					$errors = $actor->errors;
					die(current($errors));
				} else {
					$results = $actor->records;
				}	
				
				// Set num_results to $results array value
				$num_results = count($results);

			}

		} else { // The form wasn't posted, get all records

			// Initialize the Actor class
			$actor = new Actor($db);

			// Get all records from the database
			$actor->selectAll();
			if ($actor->errors) {
				$errors = $actor->errors;
				die(current($errors));
			} else {
				$results = $actor->records;
			}	

		}

		// include view
		if (isset($_GET['print']))
			include_once('../views/actors/print_search.php');
		else
			include_once('../views/actors/search.php');
		
	}
	
	
	// READ METHOD

	public function read() {
		
		require_once('../classes/Database.php');
		require_once('../classes/Model.php');
		require_once('../models/Actor.php');
		
		// Connect to database
		$db = Database::connect();
		
		$actor = new Actor($db);
		$actor->read($_GET['id']);
		if ($actor->errors) {
			$errors = $actor->errors;
			die(current($errors));
		} elseif (!$actor->records) {
			echo '<p>Sorry, we can’t find the actor you’re looking for</p>';
		} else {
			$record = current($actor->records);
			echo '<h2>'.htmlspecialchars($record['first_name'], ENT_QUOTES).' '.htmlspecialchars($record['last_name'], ENT_QUOTES).'</h2>';
		}
		
		// include view
		include_once('../views/actors/actors.read.php');
		
	}
	
	
	
	// CREATE METHOD

	public function insert() {
		
		// Include require classes
		require_once('../classes/Database.php');
		require_once('../classes/Model.php');
		require_once('../models/Actor.php');
		
		
		// Initialize vars
		$vars = array();
		$errors = array();
		
			
		// Check if form was submitted
		if (isset($_POST['first_name']) && isset($_POST['last_name'])) { // Form posted
			
			// Validate input
			if (!strlen($_POST['first_name']))
				$errors['first_name'] = 'Please enter the first name';
			if (!strlen($_POST['last_name']))
				$errors['last_name'] = 'Please enter the last name';

			// Process insert
			if (!$errors) {
				$actor = new Actor(Database::connect());
				$actor->insert($_POST['first_name'], $_POST['last_name']);
				if ($actor->errors) {
					die('mysql error');
				}
			}

			// Show form errors or return success
			if ($errors) {
				$vars = array(
					'first_name' => htmlspecialchars($_POST['first_name'], ENT_QUOTES),
					'last_name' => htmlspecialchars($_POST['last_name'], ENT_QUOTES)
				);
				$endpoint = '/movies/public/actors/create';
				include_once('../views/actors/forms/actor.insert.form.php');
			} else { // no form errors
				$new_records = $actor->records;
				$actor_name = htmlspecialchars($_POST['first_name'].' '.$_POST['last_name'], ENT_QUOTES);
				$actor_id = key($new_records);
				include_once('../views/actors/insert.success.php');
			}

		} else { // Form not posted
			
			$endpoint = '/movies/public/actors/create';
			include_once('../views/actors/forms/actors.insert.form.php');

		}

	}
	
	//UPDATE METHOD

	public function update() {

		// Include require classes
		require_once('../classes/Database.php');
		require_once('../classes/Model.php');
		require_once('../models/Actor.php');

		// Check if id is valid
		$actor = new Actor(Database::connect());
		$actor->read($_GET['id']);
		if (!$actor->records) {
			echo 'not found';
			exit;
		}

		// Initialize vars
		$vars = array();
		$errors = array();

		// Check if form was submitted
		if (isset($_POST['first_name']) && isset($_POST['last_name'])) { // Form posted

			// Validate input
			if (!strlen($_POST['first_name']))
				$errors['first_name'] = 'Please enter the first name';
			if (!strlen($_POST['last_name']))
				$errors['last_name'] = 'Please enter the last name';

			// Process update
			if (!$errors) {
				$actor->update($_GET['id'], $_POST['first_name'], $_POST['last_name']);
				if ($actor->errors) {
					die('mysql error');
				}
			}

			// Show form errors or return success
			if ($errors) {
				$vars = array(
					'first_name' => htmlspecialchars($_POST['first_name'], ENT_QUOTES),
					'last_name' => htmlspecialchars($_POST['last_name'], ENT_QUOTES)
				);
				$endpoint = '/movies/public/actors/'.$_GET['id'].'/update';
				include_once('../views/actors/forms/actors.insert.form.php');
			} else { // no form errors
				$actor_name = htmlspecialchars($_POST['first_name'].' '.$_POST['last_name'], ENT_QUOTES);
				$actor_id = $_GET['id'];
				include_once('../views/actors/insert.success.php');
			}

		} else { // Form not posted

			// Return the actor
			$records = $actor->records;
			$this_actor = current($records);
			$vars = array(
				'first_name' => htmlspecialchars($this_actor['first_name'], ENT_QUOTES),
				'last_name' => htmlspecialchars($this_actor['last_name'], ENT_QUOTES)
			);
			$endpoint = '/movies/public/actors/'.$this_actor['actor_id'].'/update';
			include_once('../views/actors/forms/actors.insert.form.php');

		}

	}
	
	// DELETE METHOD

	public function delete() {		
		
		// Include require classes
		require_once('../classes/Database.php');
		require_once('../classes/Model.php');
		require_once('../models/Actor.php');

		// Check if id is valid
		$actor = new Actor(Database::connect());
		$actor->read($_GET['id']);
		if (!$actor->records) {
			echo 'not found';
			exit;
		}

		// Initialize vars
		$vars = array();
		$errors = array();

		// Check if form was submitted
		if (isset($_POST['confirm'])) {
		
			$actor->delete($_GET['id']);
			if ($actor->errors) {
				die('mysql error');	
			}
		
			//Return views
			include_once('../views/actors/delete.success.php');
		
		} else {
			
			$endpoint = '/movies/public/actors/'.$_GET['id'].'/delete';
			include_once('../views/actors/forms/actors.delete.form.php');
			
		}	
	
	}
	
}

?>