<?php

class Rental extends Model {

	public function selectAll() {
		$q = 'SELECT rental.*, film.title AS film_title, CONCAT_WS(" ", customer.first_name, customer.last_name) AS customer_name, CONCAT_WS(" ", staff.first_name, staff.last_name) AS staff_name, payment.amount AS payment_amount, payment_date, inventory.store_id AS store_id FROM rental JOIN inventory ON rental.inventory_id = inventory.inventory_id JOIN film ON inventory.film_id = film.film_id JOIN customer ON rental.customer_id = customer.customer_id JOIN staff ON rental.staff_id = staff.staff_id LEFT JOIN payment ON rental.rental_id = payment.rental_id';
		$this->process($q);
	}

	public function selectBasicSearch($search) {
		$q = sprintf('SELECT rental.*, film.title AS film_title, CONCAT_WS(" ", customer.first_name, customer.last_name) AS customer_name, CONCAT_WS(" ", staff.first_name, staff.last_name) AS staff_name, payment.amount AS payment_amount, payment_date, inventory.store_id AS store_id FROM rental JOIN inventory ON rental.inventory_id = inventory.inventory_id JOIN film ON inventory.film_id = film.film_id JOIN customer ON rental.customer_id = customer.customer_id JOIN staff ON rental.staff_id = staff.staff_id LEFT JOIN payment ON rental.rental_id = payment.rental_id WHERE film.title LIKE "%s%%" OR customer.first_name LIKE "%s%%" OR customer.last_name LIKE "%s%%"', $this->db->real_escape_string($search), $this->db->real_escape_string($search), $this->db->real_escape_string($search));
		$this->process($q);
	}

	public function read($id) {
		$q = sprintf('SELECT rental.*, film.title AS film_title, CONCAT_WS(" ", customer.first_name, customer.last_name) AS customer_name, CONCAT_WS(" ", staff.first_name, staff.last_name) AS staff_name, payment.amount AS payment_amount, payment_date, inventory.store_id AS store_id FROM rental JOIN inventory ON rental.inventory_id = inventory.inventory_id JOIN film ON inventory.film_id = film.film_id JOIN customer ON rental.customer_id = customer.customer_id JOIN staff ON rental.staff_id = staff.staff_id LEFT JOIN payment ON rental.rental_id = payment.rental_id WHERE rental.rental_id = %u', $this->db->real_escape_string($id));
		$this->process($q);
	}

	public function insert($rental_date, $inventory_id, $customer_id, $return_date, $staff_id) {
		$q = sprintf('INSERT INTO rental (rental_date, inventory_id, customer_id, return_date, staff_id) VALUES ("%s", %u, %u, "%s", %u)', 
			$this->db->real_escape_string($rental_date), 
			$this->db->real_escape_string($inventory_id), 
			$this->db->real_escape_string($customer_id),
			$this->db->real_escape_string($return_date), 
			$this->db->real_escape_string($staff_id)
		);
		$this->process($q);
	}

	public function update($id, $rental_date, $inventory_id, $customer_id, $return_date, $staff_id) {
		$q = sprintf('UPDATE rental SET rental_date = "%s", inventory_id = %u, customer_id = %u, return_date = "%s", staff_id = %u WHERE rental_id = %u', 
			$this->db->real_escape_string($rental_date), 
			$this->db->real_escape_string($inventory_id), 
			$this->db->real_escape_string($customer_id),
			$this->db->real_escape_string($return_date), 
			$this->db->real_escape_string($staff_id),
			$this->db->real_escape_string($id)
		);
		$this->process($q);
	}

	public function delete($id) {
		$q = sprintf('DELETE FROM rental WHERE rental_id = %u', $this->db->real_escape_string($id));
		$this->process($q);
	}

}

?>