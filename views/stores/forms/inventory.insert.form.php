<form action="<?php echo $endpoint; ?>" method="post">
	<label for="first_name">Film ID</label>
	<input type="text" name="film_id" value="<?php echo isset($vars['film_id']) ? $vars['film_id'] : ''; ?>">
	<?php echo isset($errors['film_id']) ? '<p class="form_error">'.$errors['film_id'].'</p>' : ''; ?>
	<label for="last_name">Store</label>
	<input type="text" name="store_id" value="<?php echo isset($vars['store_id']) ? $vars['store_id'] : ''; ?>">
	<?php echo isset($errors['store_id']) ? '<p class="form_error">'.$errors['store_id'].'</p>' : ''; ?>
	<button type="submit">Submit</button>
</form>