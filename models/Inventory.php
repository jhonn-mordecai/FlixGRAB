<?php

class Inventory extends Model {

	public function selectAll() {
		$q = 'SELECT inventory.*, film.title AS film_title FROM inventory JOIN film ON inventory.film_id = film.film_id';
		$this->process($q);
	}

	public function selectBasicSearch($search) {
		$q = sprintf('SELECT inventory_id, store_id, film.title AS film_title FROM inventory JOIN film ON inventory.film_id = film.film_id WHERE title LIKE "%s%%"', $this->db->real_escape_string($search));
		$this->process($q);
	}

	public function read($id) {
		$q = sprintf('SELECT inventory_id, film.title AS film_title FROM inventory JOIN film ON inventory.film_id = film.film_id WHERE inventory_id = %u', $this->db->real_escape_string($id));
		$this->process($q);
	}

	public function insert($film_id, $store_id) {
		$q = sprintf('INSERT INTO inventory (film_id, store_id) VALUES (%u, %u)', 
			$this->db->real_escape_string($film_id), 
			$this->db->real_escape_string($store_id)
		);
		$this->process($q);
	}

	public function update($inventory_id, $film_id, $store_id) {
		$q = sprintf('UPDATE inventory SET film_id = %u, store_id = %u WHERE inventory_id = %u', 
			$this->db->real_escape_string($film_id), 
			$this->db->real_escape_string($store_id),
			$this->db->real_escape_string($inventory_id)
		);
		$this->process($q);
	}

	public function delete($id) {
		$q = sprintf('DELETE FROM inventory WHERE inventory_id = %u', $this->db->real_escape_string($id));
		$this->process($q);
	}

}

?>