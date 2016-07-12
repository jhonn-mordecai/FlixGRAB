<?php include_once('../templates/header.php'); ?>

<div class="form_container">
	<div class="container">
		<form action="<?php echo $endpoint; ?>" method="post">
			<label for="first_name">First Name</label>
			<input type="text" name="first_name" value="<?php echo isset($vars['first_name']) ? $vars['first_name'] : ''; ?>">
			<?php echo isset($errors['first_name']) ? '<p class="form_error">'.$errors['first_name'].'</p>' : ''; ?>
			<br />
			<label for="last_name">Last Name</label>
			<input type="text" name="last_name" value="<?php echo isset($vars['last_name']) ? $vars['last_name'] : ''; ?>"><br />
			<?php echo isset($errors['last_name']) ? '<p class="form_error">'.$errors['last_name'].'</p>' : ''; ?>
			<br />
			<button type="submit">Submit</button>
		</form>
	</div>
</div>
<?php include_once('../templates/footer.php'); ?>