
<?php include_once('../templates/header.php'); ?>


<form id="search" action="/movies/public/rentals/" method="POST">
	<div class="container">
		<input id="search_field" type="text" name="q" placeholder="Search by Movie Title or Customer Name" value="<?php echo htmlspecialchars($q, ENT_QUOTES); ?>" />
		<button class="search_button"></button>
	</div>
</form>

<div id="main_container">

	<h2 class="page_title">Rentals</h2>
	
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
					<th>Customer</th>
					<th>Movie Title</th>
					<th>Date</th>
					<th>Payment</th>
					<th>Store Location</th>
					<th>Staff Name</th>
				</tr>';
		
		// Loop through and output results
		foreach ($results as $key => $value) {
			
			if (isset($_POST['q'])) {
				
				echo '<tr>
						<td>'.htmlspecialchars(ucwords(strtolower($value['customer_name'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['film_title'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars($value['payment_date'], ENT_QUOTES).'</td>
						<td>$'.htmlspecialchars($value['payment_amount'], ENT_QUOTES).'</td>
						<td>'.htmlspecialchars($value['store_id'], ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['staff_name'])), ENT_QUOTES).'</td>
					  </tr>';
			
			} else {
				
				echo '<tr>
						<td>'.htmlspecialchars(ucwords(strtolower($value['customer_name'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['film_title'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars($value['payment_date'], ENT_QUOTES).'</td>
						<td>$'.htmlspecialchars($value['payment_amount'], ENT_QUOTES).'</td>
						<td>'.htmlspecialchars($value['store_id'], ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['staff_name'])), ENT_QUOTES).'</td>
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