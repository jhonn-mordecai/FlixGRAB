<?php include_once('../templates/header.php'); ?>

<div class="form_container movie_form">
	<div class="container">
		<form action="<?php echo $endpoint; ?>" method="post">
			
			<label for="title">Title</label>
			<input type="text" name="title" value="<?php echo isset($vars['title']) ? $vars['title'] : ''; ?>">
			<?php echo isset($errors['title']) ? '<p class="form_error">'.$errors['title'].'</p>' : ''; ?>
			
			<label for="description">Description</label>
			<input type="textarea" name="description" value="<?php echo isset($vars['description']) ? $vars['description'] : ''; ?>">
			<?php echo isset($errors['description']) ? '<p class="form_error">'.$errors['description'].'</p>' : ''; ?>
			<br />
			<label for="release_year">Release Year</label>
			<input type="text" name="release_year" value="<?php echo isset($vars['release_year']) ? $vars['release_year'] : ''; ?>">
			<?php echo isset($errors['release_year']) ? '<p class="form_error">'.$errors['release_year'].'</p>' : ''; ?>
			
			
			<label for="language">Language</label>
			<select name="language">
				<?php
				foreach ($languages as $key => $value)
					echo '<option value="'.$value['language_id'].'">'.htmlspecialchars($value['name'], ENT_QUOTES).'</option>';
				?>
			</select>
			<?php echo isset($errors['language']) ? '<p class="form_error">'.$errors['language'].'</p>' : ''; ?>
			<br />
			<!-- <input type="text" name="language_id" value="<?php echo isset($vars['language_id']) ? $vars['language_id'] : ''; ?>">
			<?php echo isset($errors['language_id']) ? '<p class="form_error">'.$errors['language_id'].'</p>' : ''; ?> -->
			
			
			<label for="rental_duration">Rental Duration</label>
			<input type="text" name="rental_duration" value="<?php echo isset($vars['rental_duration']) ? $vars['rental_duration'] : ''; ?>">
			<?php echo isset($errors['rental_duration']) ? '<p class="form_error">'.$errors['rental_duration'].'</p>' : ''; ?>
			
			<label for="rental_rate">Rental Rate</label>
			<input type="text" name="rental_rate" value="<?php echo isset($vars['rental_rate']) ? $vars['rental_rate'] : ''; ?>">
			<?php echo isset($errors['rental_rate']) ? '<p class="form_error">'.$errors['rental_rate'].'</p>' : ''; ?>
			<br />
			<label for="length">Length</label>
			<input type="text" name="length" value="<?php echo isset($vars['length']) ? $vars['length'] : ''; ?>">
			<?php echo isset($errors['length']) ? '<p class="form_error">'.$errors['length'].'</p>' : ''; ?>
			
			<label for="replacement_cost">Replacement Cost</label>
			<input type="text" name="replacement_cost" value="<?php echo isset($vars['replacement_cost']) ? $vars['replacement_cost'] : ''; ?>">
			<?php echo isset($errors['replacement_cost']) ? '<p class="form_error">'.$errors['replacement_cost'].'</p>' : ''; ?>
			<br />
			<label for="rating">Rating</label>
			<input type="text" name="rating" value="<?php echo isset($vars['rating']) ? $vars['rating'] : ''; ?>">
			<?php echo isset($errors['rating']) ? '<p class="form_error">'.$errors['rating'].'</p>' : ''; ?>
			
			<label for="special_features">Special Features</label>
			<input type="text" name="special_features" value="<?php echo isset($vars['special_features']) ? $vars['special_features'] : ''; ?>">
			<?php echo isset($errors['special_features']) ? '<p class="form_error">'.$errors['special_features'].'</p>' : ''; ?>
			<br />
			<button type="submit">Submit</button>
			
		</form>
	</div>
</div>

<?php include_once('../templates/footer.php'); ?>