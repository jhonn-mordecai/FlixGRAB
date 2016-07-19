<?php 
	
	class MovieController {
		
		public function search() {
		
			// Require files
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Movie.php');
			
			// Connect to database
			$db = Database::connect();
			
			// Initiate vars
			//$all = "";
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
			
					// Initialize the Movie class
					$movie = new Movie($db);
			
					// Process user search
					$movie->selectAdvancedSearch($_POST['q']);
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
			
				// Initialize the Movie class
				$movie = new Movie($db);
			
				// Get all records from the database
				$movie->selectAll();
				if ($movie->errors) {
					$errors = $movie->errors;
					die(current($errors));
				} else {
					$results = $movie->records;
				}	
			
			}
			
			// include view
			include_once('../views/movies/search.php');
		}
		
		
		// CREATE FUNCTION
		
		public function insert() {
			
			// Include require classes
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Movie.php');
			require_once('../models/Language.php');
			
			
			// Get all languages from the db
			$languages = $this->getLanguages();
	
			// Check if form was posted
			if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['release_year']) && isset($_POST['language_id']) && isset($_POST['rental_duration']) && isset($_POST['rental_rate']) && isset($_POST['length']) && isset($_POST['replacement_cost']) && isset($_POST['rating']) && isset($_POST['special_features'])) {
	
				// Validate values
				if (!array_key_exists($_POST['language'], $languages))
					$errors['language'] = 'Please select a valid language';
	
			} else { // form was not posted
	
				// Include film form
				include_once('../views/movies/forms/movies.insert.form.php');
	
			}
			
			
			// Initialize vars
			$vars = array();
			$errors = array();
	
			// Check if form was submitted
			if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['release_year']) && isset($_POST['language_id']) && isset($_POST['rental_duration']) && isset($_POST['rental_rate']) && isset($_POST['length']) && isset($_POST['replacement_cost']) && isset($_POST['rating']) && isset($_POST['special_features'])) { // Form posted
	
				// Validate input
				if (!strlen($_POST['title']))
					$errors['title'] = 'Please enter a title';
				if (!strlen($_POST['description']))
					$errors['description'] = 'Please enter a description of the film';
				if (!strlen($_POST['release_year']))
					$errors['release_year'] = 'Please enter a release year';
				if (!strlen($_POST['language_id']))
					$errors['language_id'] = 'Please enter a language';
				if (!strlen($_POST['rental_duration']))
					$errors['rental_duration'] = 'Please enter the duration of the rental';
				if (!strlen($_POST['rental_rate']))
					$errors['rental_rate'] = 'Please enter the cost of the rental';
				if (!strlen($_POST['length']))
					$errors['length'] = 'Please enter the length of the film (in minutes)';
				if (!strlen($_POST['replacement_cost']))
					$errors['replacement_cost'] = 'Please enter the rental replacement cost';
				if (!strlen($_POST['rating']))
					$errors['rating'] = 'Please enter the film\'s MPAA rating';
				if (!strlen($_POST['special_features']))
					$errors['special_features'] = 'Please enter rental\'s special features';
				
	
				// Process insert
				if (!$errors) {
					$movie = new Movie(Database::connect());
					$movie->insert($_POST['title'], $_POST['description'], $_POST['release_year'], $_POST['language_id'], $_POST['rental_duration'], $_POST['rental_rate'], $_POST['length'], $_POST['replacement_cost'], $_POST['rating'], $_POST['special_features']);
					if ($movie->errors) {
						die('mysql error');
					}
				}
	
				// Show form errors or return success
				if ($errors) {
					$vars = array(
						'title' => htmlspecialchars($_POST['title'], ENT_QUOTES),
						'description' => htmlspecialchars($_POST['description'], ENT_QUOTES),
						'release_year' => htmlspecialchars($_POST['release_year'], ENT_QUOTES),
						'language_id' => htmlspecialchars($_POST['language_id'], ENT_QUOTES),
						'rental_duration' => htmlspecialchars($_POST['rental_duration'], ENT_QUOTES),
						'rental_rate' => htmlspecialchars($_POST['rental_rate'], ENT_QUOTES),
						'length' => htmlspecialchars($_POST['length'], ENT_QUOTES),
						'replacement_cost' => htmlspecialchars($_POST['replacement_cost'], ENT_QUOTES),
						'rating' => htmlspecialchars($_POST['rating'], ENT_QUOTES),
						'special_features' => htmlspecialchars($_POST['special_features'], ENT_QUOTES)
					);
					$endpoint = '/movies/public/movies/create';
					include_once('../views/movies/forms/movies.insert.form.php');
				} else { // no form errors
					$new_records = $movie->records;
					$title = htmlspecialchars($_POST['title'], ENT_QUOTES);
					$description = htmlspecialchars($_POST['description'], ENT_QUOTES);
					$release_year = htmlspecialchars($_POST['release_year'], ENT_QUOTES);
					$language_id = htmlspecialchars($_POST['language_id'], ENT_QUOTES);
					$rental_duration = htmlspecialchars($_POST['rental_duration'], ENT_QUOTES);
					$rental_rate = htmlspecialchars($_POST['rental_rate'], ENT_QUOTES);
					$length = htmlspecialchars($_POST['length'], ENT_QUOTES);
					$replacement_cost = htmlspecialchars($_POST['replacement_cost'], ENT_QUOTES);
					$rating = htmlspecialchars($_POST['rating'], ENT_QUOTES);
					$special_features = htmlspecialchars($_POST['special_features'], ENT_QUOTES);
					$film_id = key($new_records);
					include_once('../views/movies/insert.success.php');
				}
	
			} else { // Form not posted
	
				$endpoint = '/movies/public/movies/create';
				include_once('../views/actors/forms/movies.insert.form.php');
	
			}
	
						
		}
		
		
		
		//READ FUNCTION
		
		public function read() {
			
			// Require files
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Movie.php');
			
			// Connect to database
			$db = Database::connect();
			
			$movie = new Movie($db);
			$movie->read($_GET['id']);
			if ($movie->errors) {
				$errors = $movie->errors;
				die(current($errors));
			} elseif (!$movie->records) {
				echo '<p>Sorry, we can’t find the movie you’re looking for</p>';
			} else {
				$record = current($movie->records);
				echo '<ul>';
				echo '<li>'.htmlspecialchars($record['title'], ENT_QUOTES).'</li>';
				echo '<li>'.htmlspecialchars($record['language_name'], ENT_QUOTES).'</li>';
				echo '</ul>';
			}
			
			// include view
			include_once('../views/movies/movies.read.php');
			
		}
		
		// UPDATE FUNCTION
		
		public function update() {
			
			// Include require classes
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Movie.php');
			require_once('../models/Language.php');
			
			
			// Check if id is valid
			$movie = new Movie(Database::connect());
			$movie->read($_GET['id']);
			if (!$movie->records) {
				echo 'not found';
				exit;
			}
			
			// Get all languages from the db
			$languages = $this->getLanguages();			
			
			// Initialize vars
			$vars = array();
			$errors = array();
	
			if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['release_year']) && isset($_POST['language_id']) && isset($_POST['rental_duration']) && isset($_POST['rental_rate']) && isset($_POST['length']) && isset($_POST['replacement_cost']) && isset($_POST['rating']) && isset($_POST['special_features'])) { // Form posted
	
				// Validate input
				if (!strlen($_POST['title']))
					$errors['title'] = 'Please enter a title';
				if (!strlen($_POST['description']))
					$errors['description'] = 'Please enter a description of the film';
				if (!strlen($_POST['release_year']))
					$errors['release_year'] = 'Please enter a release year';
				if (!strlen($_POST['language_id']))
					$errors['language_id'] = 'Please enter a language';
				if (!strlen($_POST['rental_duration']))
					$errors['rental_duration'] = 'Please enter the duration of the rental';
				if (!strlen($_POST['rental_rate']))
					$errors['rental_rate'] = 'Please enter the cost of the rental';
				if (!strlen($_POST['length']))
					$errors['length'] = 'Please enter the length of the film (in minutes)';
				if (!strlen($_POST['replacement_cost']))
					$errors['replacement_cost'] = 'Please enter the rental replacement cost';
				if (!strlen($_POST['rating']))
					$errors['rating'] = 'Please enter the film\'s MPAA rating';
				if (!strlen($_POST['special_features']))
					$errors['special_features'] = 'Please enter rental\'s special features';
				if (!array_key_exists($_POST['language'], $languages))
					$errors['language'] = 'Please select a valid language';

	
				// Process update
				if (!$errors) {
					$movie->update($_POST['title'], $_POST['description'], $_POST['release_year'], $_POST['language_id'], $_POST['rental_duration'], $_POST['rental_rate'], $_POST['length'], $_POST['replacement_cost'], $_POST['rating'], $_POST['special_features']);
					if ($movie->errors) {
						die('mysql error');
					}
				}
	
				// Show form errors or return success
				if ($errors) {
					$vars = array(
						'title' => htmlspecialchars($_POST['title'], ENT_QUOTES),
						'description' => htmlspecialchars($_POST['description'], ENT_QUOTES),
						'release_year' => htmlspecialchars($_POST['release_year'], ENT_QUOTES),
						'language_id' => htmlspecialchars($_POST['language_id'], ENT_QUOTES),
						'rental_duration' => htmlspecialchars($_POST['rental_duration'], ENT_QUOTES),
						'rental_rate' => htmlspecialchars($_POST['rental_rate'], ENT_QUOTES),
						'length' => htmlspecialchars($_POST['length'], ENT_QUOTES),
						'replacement_cost' => htmlspecialchars($_POST['replacement_cost'], ENT_QUOTES),
						'rating' => htmlspecialchars($_POST['rating'], ENT_QUOTES),
						'special_features' => htmlspecialchars($_POST['special_features'], ENT_QUOTES)
					);
					$endpoint = '/movies/public/movies/'.$_GET['id'].'/update';
					include_once('../views/movies/forms/movies.insert.form.php');
				} else { // no form errors
					$title = htmlspecialchars($_POST['title'], ENT_QUOTES);
					$description = htmlspecialchars($_POST['description'], ENT_QUOTES);
					$release_year = htmlspecialchars($_POST['release_year'], ENT_QUOTES);
					$language_id = htmlspecialchars($_POST['language_id'], ENT_QUOTES);
					$rental_duration = htmlspecialchars($_POST['rental_duration'], ENT_QUOTES);
					$rental_rate = htmlspecialchars($_POST['rental_rate'], ENT_QUOTES);
					$length = htmlspecialchars($_POST['length'], ENT_QUOTES);
					$replacement_cost = htmlspecialchars($_POST['replacement_cost'], ENT_QUOTES);
					$rating = htmlspecialchars($_POST['rating'], ENT_QUOTES);
					$special_features = htmlspecialchars($_POST['special_features'], ENT_QUOTES);
					$film_id = $_GET['id'];
					include_once('../views/movies/insert.success.php');
				}
	
			} else { // Form not posted
	
				// Return the movie
				$records = $movie->records;
				$this_movie = current($records);
				$vars = array(
					'title' => htmlspecialchars($this_movie['title'], ENT_QUOTES),
					'description' => htmlspecialchars($this_movie['description'], ENT_QUOTES),
					'release_year' => htmlspecialchars($this_movie['release_year'], ENT_QUOTES),
					'language_id' => htmlspecialchars($this_movie['language_id'], ENT_QUOTES),
					'rental_duration' => htmlspecialchars($this_movie['rental_duration'], ENT_QUOTES),
					'rental_rate' => htmlspecialchars($this_movie['rental_rate'], ENT_QUOTES),
					'length' => htmlspecialchars($this_movie['length'], ENT_QUOTES),
					'replacement_cost' => htmlspecialchars($this_movie['replacement_cost'], ENT_QUOTES),
					'rating' => htmlspecialchars($this_movie['rating'], ENT_QUOTES),
					'special_features' => htmlspecialchars($this_movie['special_features'], ENT_QUOTES)
				);
				$endpoint = '/movies/public/movies/'.$this_movie['film_id'].'/update';
				include_once('../views/movies/forms/movies.insert.form.php');
	
			}
			
		}
		
		
		// DELETE FUNCTION
		
		public function delete() {
			
			// Include require classes
			require_once('../classes/Database.php');
			require_once('../classes/Model.php');
			require_once('../models/Movie.php');
	
			// Check if id is valid
			$movie = new Movie(Database::connect());
			$movie->read($_GET['id']);
			if (!$movie->records) {
				echo 'not found';
				exit;
			}
	
			// Initialize vars
			$vars = array();
			$errors = array();
	
			// Check if form was submitted
			if (isset($_POST['confirm'])) {
			
				$movie->delete($_GET['id']);
				if ($movie->errors) {
					die('mysql error');
					
				}
			
				//Return views
				include_once('../views/movies/delete.success.php');
			
			} else {
				
				$endpoint = '/movies/public/movies/'.$_GET['id'].'/delete';
				include_once('../views/movies/forms/movies.delete.form.php');
				
			}
						
		}
		
		
		private function getLanguages() {
			$languages = new Language(Database::connect());
			$languages->selectAll();
			if ($languages->errors) {
				$sqlerrors = $languages->errors;
				die(current($sqlerrors));
			} else {
				$languages = $languages->records;
			}
			return $languages;
		}
		
		
	}
?>