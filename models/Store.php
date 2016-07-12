<?php

class Store extends Model {

	public function selectAll() {
		$q = "SELECT * FROM store JOIN address ON store.address_id = address.address_id JOIN city ON address.city_id = city.city_id JOIN country ON city.country_id = country.country_id";
		/*$r = */$this->process($q);
	}
	
	
	public function read() {
		$q = sprintf('SELECT inventory_id, store_id, film.title AS film_title FROM inventory JOIN film ON inventory.film_id = film.film_id WHERE store_id = %u', $this->db->real_escape_string($q));
		$this->process($q);
	}
	

}

?>