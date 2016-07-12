<?php

class Movie extends Model {

	public function selectAll() {
		//$q = 'SELECT * FROM film';
		$q = 'SELECT film.film_id, title AS movie, release_year, rating, GROUP_CONCAT(" ", CONCAT_WS(" ", actor.first_name, actor.last_name)) AS actors, description FROM film LEFT JOIN film_actor ON film.film_id = film_actor.film_id LEFT JOIN actor ON film_actor.actor_id = actor.actor_id GROUP BY film_id';
		$this->process($q);
	}
	
	public function selectBasicSearch($q) {
		$q = sprintf('SELECT * FROM film WHERE title LIKE "%%%s%%"', $this->db->real_escape_string($q), $this->db->real_escape_string($q));
		$this->process($q);
	}
	
	
	//  When adding the advanced search function
	public function selectAdvancedSearch($q) {
		$q = sprintf('SELECT film.film_id, title AS movie, release_year, rating, GROUP_CONCAT(" ", CONCAT_WS(" ", actor.first_name, actor.last_name)) AS actors, description FROM film LEFT JOIN film_actor ON film.film_id = film_actor.film_id LEFT JOIN actor ON film_actor.actor_id = actor.actor_id WHERE film.title LIKE "%s%%" GROUP BY film_id', $this->db->real_escape_string($q), $this->db->real_escape_string($q));
		$this->process($q);
	}
	
	//CREATE
	public function insert($title, $description, $release_year, $language_id, $rental_duration, $rental_rate, $length, $replacement_cost, $rating, $special_features) {
		$q = sprintf('INSERT INTO film (title, description, release_year, language_id, rental_duration, rental_rate, length, replacement_cost, rating, special_features) VALUES ("%s", "%s", %u, %u, %u, %f, %u, %f, "%s", "%s")', $this->db->real_escape_string($title), $this->db->real_escape_string($description), $this->db->real_escape_string($release_year), $this->db->real_escape_string($language_id), $this->db->real_escape_string($rental_duration), $this->db->real_escape_string($rental_rate), $this->db->real_escape_string($length), $this->db->real_escape_string($replacement_cost), $this->db->real_escape_string($rating), $this->db->real_escape_string($special_features));
		$this->process($q);
	}
	
	//DELETE
	public function delete($id) {
		$q = sprintf('DELETE FROM film WHERE film_id = %u', $this->db->real_escape_string($id));
		$this->process($q);
	}
	
	//UPDATE
	public function update($id, $title, $description, $release_year, $language_id, $rental_duration, $rental_rate, $length, $replacement_cost, $rating, $special_features) {
		$q = sprintf('UPDATE film SET title = "%s", description = "%s", release_year = %u, language_id = %u, rental_duration = %u, rental_rate = %f, length = %u, replacement_cost = %f, rating = "%s", special_features = "%s" WHERE film_id = %u', $this->db->real_escape_string($title), $this->db->real_escape_string($description), $this->db->real_escape_string($release_year), $this->db->real_escape_string($language_id), $this->db->real_escape_string($rental_duration), $this->db->real_escape_string($rental_rate), $this->db->real_escape_string($length), $this->db->real_escape_string($replacement_cost), $this->db->real_escape_string($rating), $this->db->real_escape_string($special_features), $this->db->real_escape_string($id));
		$this->process($q);
	}

}

?>

