<?php 
	
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	
	// INLCUDE MODEL
	require('../classes/Database.php');
	require('../classes/Model.php');
	require('../models/Actor.php');
	require('../models/Customer.php');
	require('../models/Inventory.php');
	require('../models/Movie.php');
	require('../models/Rental.php');
	require('../models/Store.php');
	
	//CONNECT TO DATABASE
	$db = Database::connect();
	
	//INITIALIZE MODEL
	//$model = new Actor($db);
	//$model = new Customer($db);
	//$model = new Inventory($db);
	//$model = new Movie($db);
	//$model = new Rental($db);
	$model = new Store($db);
	
	
	$model->selectAll();
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}
	
	//CALL ACTOR METHOD
	
	/*$model->selectBasicSearch('ed');
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->insert('John', 'Mordecai');
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->delete(217);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->update(217, 'Jhonn', 'Mordonna');
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->read(3);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	
	//($title, $description, $release_year, $language_id, $rental_duration, $rental_rate, $length, $replacement_cost, $rating, $special_features)
	
	//CALL MOVIE METHOD
	
	/*$model->selectBasicSearch('ace');
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->insert('Wild Bill', 'The story of good Wild Bill of the West', 1978, 2, 4, 3.99, 120, 14.99, 'R', 'Trailers');
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->update(1005, 'Wild Sill', 'The story of good Wild Bill of the West and Pecos', 1972, 2, 4, 3.99, 120, 14.99, 'R', 'Commentaries');
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->delete(1005);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->read(3);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	
	
	//CALL CUSTOMER METHOD
	/*$model->selectBasicSearch('mary');
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->insert(1, 'MaryAnne', 'Mayelene', 'mm@me.com', 10, 1);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->delete(617);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->update(617, 1, 'MaryAnne', 'Dayelene', 'mm@me.com', 10, 1);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->read(617);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	
	
	//CALL INVENTORY METHOD
	
	/*$model->selectBasicSearch('ace');
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->insert(1004, 1);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->delete(4582);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->update(4581, 1000, 1);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->read(3);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	//($rental_date, $inventory_id, $customer_id, $return_date, $staff_id)
	
	//CALL RENTAL METHOD
	
	/*$model->selectBasicSearch('ace');
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->insert(05-24-2005, 3, 5, 05-28-2005, 2);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->delete(16050);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->update(16050, 05-24-2005, 3, 5, 05-30-2005, 2);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	/*$model->read(3);
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}*/
	
	
	echo '<pre>';
	print_r($model);
	echo '</pre>';
	exit;
	
	
?>