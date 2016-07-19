<?php

class Store extends Model {

	public function selectAll() {
		$q = "SELECT * FROM store JOIN address ON store.address_id = address.address_id JOIN city ON address.city_id = city.city_id JOIN country ON city.country_id = country.country_id";
		$r = $this->process($q);
	}
	
	
	public function read($store_id) {
		$q = sprintf("SELECT * FROM store JOIN address ON store.address_id = address.address_id JOIN city ON address.city_id = city.city_id JOIN country ON city.country_id = country.country_id WHERE store_id = %u", $this->db->real_escape_string($store_id));
		$r = $this->process($q);
	}
	

}

?>