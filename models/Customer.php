<?php

class Customer extends Model {

	public function selectAll() {
		//$q = 'SELECT customer.*, address.address AS address1, address2, district, city.city AS city_name, country.country AS country_name, postal_code, phone FROM customer JOIN address ON customer.address_id = address.address_id JOIN city ON address.city_id = city.city_id JOIN country ON city.country_id = country.country_id';
		$q = 'SELECT customer.customer_id, CONCAT_WS(" ", first_name, last_name) AS customer_name, email, address.address AS customer_address, city.city AS city_name, postal_code, phone, country.country AS country_name, film.title AS current_rental, SUM(payment.amount) AS total_spent FROM customer JOIN address ON address.address_id = customer.address_id LEFT JOIN rental ON customer.customer_id = rental.customer_id LEFT JOIN inventory ON inventory.inventory_id = rental.inventory_id LEFT JOIN film ON film.film_id = inventory.film_id LEFT JOIN payment ON rental.rental_id = payment.rental_id JOIN city ON address.city_id = city.city_id JOIN country ON city.country_id = country.country_id WHERE customer.first_name IS NOT NULL AND customer.last_name IS NOT NULL GROUP BY customer_id';
		$this->process($q);
	}

	public function selectBasicSearch($search) {
		$q = sprintf('SELECT customer.*, address.address AS address1, address2, district, city.city AS city_name, country.country AS country_name, postal_code, phone FROM customer JOIN address ON customer.address_id = address.address_id JOIN city ON address.city_id = city.city_id JOIN country ON city.country_id = country.country_id WHERE first_name LIKE "%s%%" OR last_name LIKE "%s%%"', $this->db->real_escape_string($search), $this->db->real_escape_string($search));
		$this->process($q);
	}
	
	public function selectAdvancedSearch ($search) {
		$q = sprintf('SELECT customer.customer_id, CONCAT_WS(" ", first_name, last_name) AS customer_name, email, address.address AS customer_address, city.city AS city_name, postal_code, phone, country.country AS country_name, film.title AS current_rental, SUM(payment.amount) AS total_spent FROM customer JOIN address ON address.address_id = customer.address_id LEFT JOIN rental ON customer.customer_id = rental.customer_id LEFT JOIN inventory ON inventory.inventory_id = rental.inventory_id LEFT JOIN film ON film.film_id = inventory.film_id LEFT JOIN payment ON rental.rental_id = payment.rental_id JOIN city ON address.city_id = city.city_id JOIN country ON city.country_id = country.country_id WHERE first_name LIKE "%s%%" OR last_name LIKE "%s%%"', $this->db->real_escape_string($search), $this->db->real_escape_string($search));
		$this->process($q);
	}

	public function read($id) {
		$q = sprintf('SELECT customer.*, address.address AS address1, address2, district, city.city AS city_name, country.country AS country_name, postal_code, phone FROM customer JOIN address ON customer.address_id = address.address_id JOIN city ON address.city_id = city.city_id JOIN country ON city.country_id = country.country_id WHERE customer_id = %u', $this->db->real_escape_string($id));
		$this->process($q);
	}

	public function insert($store_id, $first_name, $last_name, $email, $address_id, $active) {
		$q = sprintf('INSERT INTO customer (store_id, first_name, last_name, email, address_id, active) VALUES (%u, "%s", "%s", "%s", %u, %u)', 
			$this->db->real_escape_string($store_id), 
			$this->db->real_escape_string($first_name),
			$this->db->real_escape_string($last_name), 
			$this->db->real_escape_string($email), 
			$this->db->real_escape_string($address_id),
			$this->db->real_escape_string($active)
		);
		$this->process($q);
	}

	public function update($id, $store_id, $first_name, $last_name, $email, $address_id, $active) {
		$q = sprintf('UPDATE customer SET store_id = %u, first_name = "%s", last_name = "%s", email = "%s", address_id = %u, active = %u WHERE customer_id = %u', 
			$this->db->real_escape_string($store_id), 
			$this->db->real_escape_string($first_name),
			$this->db->real_escape_string($last_name), 
			$this->db->real_escape_string($email), 
			$this->db->real_escape_string($address_id),
			$this->db->real_escape_string($active),
			$this->db->real_escape_string($id)
		);
		$this->process($q);
	}

	public function delete($id) {
		$q = sprintf('DELETE FROM customer WHERE customer_id = %u', $this->db->real_escape_string($id));
		$this->process($q);
	}

}

?>