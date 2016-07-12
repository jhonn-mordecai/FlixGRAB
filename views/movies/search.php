
<?php include_once('../templates/header.php'); ?>


<form id="search" action="/movies/public/movies/" method="POST">
	<div class="container">
		<input id="search_field" type="text" name="q" placeholder="Search by Movie Title or Actor Name" value="<?php echo htmlspecialchars($q, ENT_QUOTES); ?>" />
		<button class="search_button"></button>
	</div>
</form>

<div id="main_container">

	<h2 class="page_title">Movies</h2>
	
	<div class="container">
	
	<?php
	
	// Output results if needed
	if ($results) {
		
		if (isset($_POST['q'])) {
			if ($num_results==1) {
				echo '<p class="num_results">1 Record Found</p>';
			} else { 
				echo '<p class="num_results">'.$num_results.' Records Found</p>';
			}
		} else {
			echo '<p></p>';
		}
	
		//Open Table
		echo '<table>
				<tr>	
					<th>Movie</th>
					<th>Year</th>
					<th>Rating</th>
					<th>Language</th>
					<th>Actors</th>
					<th>Description</th>
					<th>Edit</th>
				</tr>';
		
		// Loop through and output results
		foreach ($results as $key => $value) {
			
			if (isset($_POST['q'])) {
				
				echo '<tr>
						<td>'.htmlspecialchars(ucwords(strtolower($value['movie'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars($value['release_year'], ENT_QUOTES).'</td>
						<td>'.htmlspecialchars($value['rating'], ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['language_name'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['actors'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucfirst(strtolower($value['description'])), ENT_QUOTES).'</td>
						<td width="13%"><a href="/movies/public/movies/'.$value['film_id'].'/update" title="Update Movie">Update</a> | <a href="/movies/public/movies/'.$value['film_id'].'/delete" title="Delete Movie">Delete</a></td>
					  </tr>';
			
			} else {
				
				echo '<tr>
						<td>'.htmlspecialchars(ucwords(strtolower($value['movie'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars($value['release_year'], ENT_QUOTES).'</td>
						<td>'.htmlspecialchars($value['rating'], ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['language_name'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['actors'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucfirst(strtolower($value['description'])), ENT_QUOTES).'.</td>
						<td width="13%"><a href="/movies/public/movies/'.$value['film_id'].'/update" title="Update Movie">Update</a> | <a href="/movies/public/movies/'.$value['film_id'].'/delete" title="Delete Movie">Delete</a></td>
					  </tr>';
					  		  	
					}
			}
		
		echo '</table>';
		//Close Table
	
	} else {
		
		if (empty($_POST['q'])) {
			echo '<p class="error_message">Please enter a movie to search for!</p>';
		} else {
		
			// Output no results message
			echo '<p class="error_message">Sorry, no records match your search...</p>';
		}
	}
	
	?>
	
	</div>
</div>
<?php include_once('../templates/footer.php'); ?>