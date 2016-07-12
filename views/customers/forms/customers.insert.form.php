<form action="<?php echo $endpoint; ?>" method="post">
	
	<label for="store_id">Store</label>
	<input type="text" name="store_id" value="<?php echo isset($vars['store_id']) ? $vars['store_id'] : ''; ?>">
	<?php echo isset($errors['store_id']) ? '<p class="form_error">'.$errors['store_id'].'</p>' : ''; ?>
	
	<label for="first_name">First Name</label>
	<input type="text" name="first_name" value="<?php echo isset($vars['first_name']) ? $vars['first_name'] : ''; ?>">
	<?php echo isset($errors['first_name']) ? '<p class="form_error">'.$errors['first_name'].'</p>' : ''; ?>
	
	<label for="last_name">Last Name</label>
	<input type="text" name="last_name" value="<?php echo isset($vars['last_name']) ? $vars['last_name'] : ''; ?>">
	<?php echo isset($errors['last_name']) ? '<p class="form_error">'.$errors['last_name'].'</p>' : ''; ?>
	
	<label for="last_name">E-Mail</label>
	<input type="text" name="email" value="<?php echo isset($vars['email']) ? $vars['email'] : ''; ?>">
	<?php echo isset($errors['email']) ? '<p class="form_error">'.$errors['email'].'</p>' : ''; ?>
	
	<label for="last_name">Address</label>
	<input type="text" name="address" value="<?php echo isset($vars['address']) ? $vars['address'] : ''; ?>">
	<?php echo isset($errors['address']) ? '<p class="form_error">'.$errors['address'].'</p>' : ''; ?>
	
	<label for="last_name">Active</label>
	<input type="text" name="active" value="<?php echo isset($vars['active']) ? $vars['active'] : ''; ?>">
	<?php echo isset($errors['active']) ? '<p class="form_error">'.$errors['active'].'</p>' : ''; ?>
	
	<button type="submit">Submit</button>

</form>