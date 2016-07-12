<?php

class Movie extends Model {
	
	/*
	public function selectAll() {
		$q = 'SELECT film.*, language.name AS language_name FROM film JOIN language ON film.language_id = language.language_id';
		$this->process($q);
	}
	*/
	
	public function selectAll() {
		$q = 'SELECT film.film_id, title AS movie, release_year, rating, GROUP_CONCAT(" ", CONCAT_WS(" ", actor.first_name, actor.last_name)) AS actors, description, language.name AS language_name FROM film LEFT JOIN film_actor ON film.film_id = film_actor.film_id LEFT JOIN actor ON film_actor.actor_id = actor.actor_id JOIN language ON film.language_id = language.language_id GROUP BY film_id';
		$this->process($q);
	}
	

	public function selectBasicSearch($search) {
		$q = sprintf('SELECT film.*, language.name AS language_name FROM film JOIN language ON film.language_id = language.language_id WHERE title LIKE "%s%%"', $this->db->real_escape_string($search));
		$this->process($q);
	}
	
	//  When adding the advanced search function
	public function selectAdvancedSearch($q) {
		$q = sprintf('SELECT film.film_id, title AS movie, release_year, rating, GROUP_CONCAT(" ", CONCAT_WS(" ", actor.first_name, actor.last_name)) AS actors, description, language.name AS language_name FROM film LEFT JOIN film_actor ON film.film_id = film_actor.film_id LEFT JOIN actor ON film_actor.actor_id = actor.actor_id JOIN language ON film.language_id = language.language_id WHERE film.title LIKE "%s%%" OR actor.first_name LIKE "%s%%" OR actor.last_name LIKE "%s%%" GROUP BY film_id', $this->db->real_escape_string($q), $this->db->real_escape_string($q), $this->db->real_escape_string($q), $this->db->real_escape_string($q), $this->db->real_escape_string($q), $this->db->real_escape_string($q), $this->db->real_escape_string($q));
		$this->process($q);
	}
	

	public function read($film_id) {
		$q = sprintf('SELECT film.*, language.name AS language_name FROM film JOIN language ON film.language_id = language.language_id WHERE film_id = %u', $this->db->real_escape_string($film_id));
		$this->process($q);
	}

	public function insert($title, $description, $release_year, $language_id, $rental_duration, $rental_rate, $length, $replacement_cost, $rating, $special_features) {
		$q = sprintf('INSERT INTO film (title, description, release_year, language_id, rental_duration, rental_rate, length, replacement_cost, rating, special_features) VALUES ("%s", "%s", "%s", %u, %u, %f, %u, %f, "%s", "%s")', 
			$this->db->real_escape_string($title), 
			$this->db->real_escape_string($description),
			$this->db->real_escape_string($release_year), 
			$this->db->real_escape_string($language_id), 
			$this->db->real_escape_string($rental_duration), 
			$this->db->real_escape_string($rental_rate), 
			$this->db->real_escape_string($length), 
			$this->db->real_escape_string($replacement_cost), 
			$this->db->real_escape_string($rating),
			$this->db->real_escape_string($special_features) 
		);
		$this->process($q);
	}

	public function update($film_id, $title, $description, $release_year, $language_id, $rental_duration, $rental_rate, $length, $replacement_cost, $rating, $special_features) {
		$q = sprintf('UPDATE film SET title = "%s", description = "%s", release_year = %u, language_id = %u, rental_duration = %u, rental_rate = %f, length = %f, replacement_cost = %f, rating = "%s", special_features = "%s" WHERE film_id = %u', 
			$this->db->real_escape_string($title), 
			$this->db->real_escape_string($description),
			$this->db->real_escape_string($release_year), 
			$this->db->real_escape_string($language_id), 
			$this->db->real_escape_string($rental_duration), 
			$this->db->real_escape_string($rental_rate), 
			$this->db->real_escape_string($length), 
			$this->db->real_escape_string($replacement_cost), 
			$this->db->real_escape_string($rating),
			$this->db->real_escape_string($special_features), 
			$this->db->real_escape_string($film_id) 
		);
		$this->process($q);
	}

	public function delete($film_id) {
		$q = sprintf('DELETE FROM film WHERE film_id = %u', $this->db->real_escape_string($film_id));
		$this->process($q);
	}
	
	public function selectStoreInInventory($store) {
		$q = sprintf('SELECT * FROM inventory JOIN films ON inventory.film_id = films.film_id WHERE inventory.store_id = %u', $this->db->real_escape_string($store));
		$this->process($q);
	}

	public function selectStoreNotInInventory($store) {
		$q = sprintf('SELECT * FROM films LEFT JOIN inventory ON films.film_id = inventory.film_id AND inventory.store_id = %u WHERE inventory_id IS NULL', $this->db->real_escape_string($store));
		$this->process($q);
	}
	
}

?>