
<?php include_once('../templates/header.php'); ?>

<form id="search" action="/movies/public/actors/" method="POST">
	<div class="container">
		<input id="search_field" type="text" name="q" placeholder="Search by Actor Name" value="<?php echo htmlspecialchars($q, ENT_QUOTES); ?>" />
		<button class="search_button"></button>
	</div>
</form>

<div id="main_container">
	
	<h2 class="page_title">Actors</h2>
	
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
					<th>Actor</th>
					<th>Movies</th>
					<th>Edit</th>
				</tr>';
		
		// Loop through and output results
		foreach ($results as $key => $value) {
			
			if (isset($_POST['q'])) {
				
				echo '<tr>
						<td width="15%">'.htmlspecialchars(ucwords(strtolower($value['actor'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['movies'])), ENT_QUOTES).'</td>
						<td width="14%"><a href="/movies/public/actors/'.$value['actor_id'].'/update" title="Update Actor">Update</a> | <a href="/movies/public/actors/'.$value['actor_id'].'/delete" title="Delete Actor">Delete</a></td>
					  </tr>';
			
			} else {
				
				echo '<tr>
						<td width="15%">'.htmlspecialchars(ucwords(strtolower($value['actor'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['movies'])), ENT_QUOTES).'</td>
						<td width="14%"><a href="/movies/public/actors/'.$value['actor_id'].'/update" title="Update Actor">Update</a> | <a href="/movies/public/actors/'.$value['actor_id'].'/delete" title="Delete Actor">Delete</a></td>
					  </tr>';
					  		  	
					}
			}
		
		echo '</table>';
		//Close Table
	
		} else {
			
			if (empty($_POST['q'])) {
				echo '<p class="error_message">Please enter an actor to search for!</p>';
			} else {
			
				// Output no results message
				echo '<p class="error_message">Sorry, no records match your search...</p>';
			}
		}
	?>
	</div>
</div>
<?php include_once('../templates/footer.php'); ?>