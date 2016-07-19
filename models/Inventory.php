<?php

class Inventory extends Model {
	
	public function read($inventory_id) {
		$q = sprintf('SELECT * FROM inventory WHERE inventory_id = %u AND active = 1', 
			$this->db->real_escape_string($inventory_id)
		);
		$this->process($q);
	}
	
	public function basicSearch($search) {
		$q = sprintf('SELECT inventory.*, film.title AS film_title FROM inventory JOIN film ON inventory.film_id = film.film_id WHERE film.title LIKE "%s%%" AND film.active = 1', 
			$this->db->real_escape_string($search)
		);
		$this->process($q);
	}

	public function insert($film_id, $store_id) {
		$q = sprintf('INSERT INTO inventory (film_id, store_id, active) VALUES (%u, %u, 1)', 
			$this->db->real_escape_string($film_id), 
			$this->db->real_escape_string($store_id)
		);
		$this->process($q);
	}

	public function delete($id) {
		$q = sprintf('UPDATE inventory SET active = 0 WHERE inventory_id = %u', $this->db->real_escape_string($id));
		$this->process($q);
	}

	public function selectStoreInInventory($store) {
		$q = sprintf("SELECT inventory.*, title FROM inventory JOIN film ON inventory.film_id = film.film_id WHERE inventory.store_id = %u AND inventory.active = 1 AND film.active = 1", $this->db->real_escape_string($store));
		$this->process($q);
	}

	public function selectStoreNotInInventory($store) {
		$q = sprintf("SELECT film.* FROM film LEFT JOIN inventory ON film.film_id = inventory.film_id AND inventory.store_id = %u AND inventory.active = 1 WHERE film.active = 1 AND inventory_id IS NULL", $this->db->real_escape_string($store));
		$this->process($q);
	}
}

?>