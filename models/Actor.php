<?php

class Actor extends Model {

	public function selectAll() {
		//$q = 'SELECT * FROM actor';
		$q = 'SELECT actor.actor_id, CONCAT_WS(" ", first_name, last_name) AS actor, GROUP_CONCAT(" ",film.title) AS movies FROM actor LEFT JOIN film_actor ON actor.actor_id = film_actor.actor_id LEFT JOIN film ON film.film_id = film_actor.film_id GROUP BY actor.actor_id';
		$this->process($q);
	}

	public function selectBasicSearch($search) {
		$q = sprintf('SELECT * FROM actor WHERE first_name LIKE "%s%%" OR last_name LIKE "%s%%"', $this->db->real_escape_string($search), $this->db->real_escape_string($search));
		$this->process($q);
	}
	
		//Advanced search function
	public function selectAdvancedSearch($search) {
		$q = sprintf('SELECT actor.actor_id, CONCAT_WS(" ", first_name, last_name) AS actor, GROUP_CONCAT(" ", film.title) AS movies FROM actor LEFT JOIN film_actor ON actor.actor_id = film_actor.actor_id LEFT JOIN film ON film_actor.film_id = film.film_id WHERE first_name LIKE "%s%%" OR last_name LIKE "%s%%" OR film.title LIKE "%s%%" GROUP BY actor.actor_id', $this->db->real_escape_string($search), $this->db->real_escape_string($search), $this->db->real_escape_string($search));
		$this->process($q);
	}

	public function read($actor_id) {
		$q = sprintf('SELECT * FROM actor WHERE actor_id = %u', $this->db->real_escape_string($actor_id));
		$this->process($q);
	}

	public function insert($first_name, $last_name) {
		$q = sprintf('INSERT INTO actor (first_name, last_name) VALUES ("%s", "%s")', $this->db->real_escape_string($first_name), $this->db->real_escape_string($last_name));
		$this->process($q);
	}

	public function update($actor_id, $first_name, $last_name) {
		$q = sprintf('UPDATE actor SET first_name = "%s", last_name = "%s" WHERE actor_id = %u', $this->db->real_escape_string($first_name), $this->db->real_escape_string($last_name), $this->db->real_escape_string($actor_id));
		$this->process($q);
	}

	public function delete($actor_id) {
		$q = sprintf('DELETE FROM actor WHERE actor_id = %u', $this->db->real_escape_string($actor_id));
		$this->process($q);
	}

}

?>