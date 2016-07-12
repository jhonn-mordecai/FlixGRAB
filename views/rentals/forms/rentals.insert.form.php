<form action="<?php echo $endpoint; ?>" method="post">
	
	<label for="first_name">Rental Date</label>
	<input type="text" name="rental_date" value="<?php echo isset($vars['rental_date']) ? $vars['rental_date'] : ''; ?>">
	<?php echo isset($errors['rental_date']) ? '<p class="form_error">'.$errors['rental_date'].'</p>' : ''; ?>
	
	<label for="last_name">Inventory ID</label>
	<input type="text" name="inventory_id" value="<?php echo isset($vars['inventory_id']) ? $vars['inventory_id'] : ''; ?>">
	<?php echo isset($errors['inventory_id']) ? '<p class="form_error">'.$errors['inventory_id'].'</p>' : ''; ?>
	
	<label for="last_name">Customer ID</label>
	<input type="text" name="customer_id" value="<?php echo isset($vars['customer_id']) ? $vars['customer_id'] : ''; ?>">
	<?php echo isset($errors['customer_id']) ? '<p class="form_error">'.$errors['customer_id'].'</p>' : ''; ?>
	
	<label for="last_name">Return Date</label>
	<input type="text" name="return_date" value="<?php echo isset($vars['return_date']) ? $vars['return_date'] : ''; ?>">
	<?php echo isset($errors['return_date']) ? '<p class="form_error">'.$errors['return_date'].'</p>' : ''; ?>
	
	<label for="last_name">Staff</label>
	<input type="text" name="staff_id" value="<?php echo isset($vars['staff_id']) ? $vars['staff_id'] : ''; ?>">
	<?php echo isset($errors['staff_id']) ? '<p class="form_error">'.$errors['staff_id'].'</p>' : ''; ?>
	
	<button type="submit">Submit</button>
</form>