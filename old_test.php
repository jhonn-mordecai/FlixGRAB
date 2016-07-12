<?php

	// include your model
	require('../models/Actor.php');
	
	// initialize your model
	$model = new Actor();
	
	// call the method you’re testing
	$model->insert('JANE', 'JONES’');
	if ($model->errors) {
		$errors = $model->errors;
		echo current($errors);
	}
	
	// output the model object to confirm success
	echo '<pre>';
	print_r($model);
	echo '</pre>';
	exit;

?>