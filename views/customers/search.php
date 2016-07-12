
<?php include_once('../templates/header.php'); ?>


<form id="search" action="/movies/public/customers/" method="POST">
	<div class="container">
		<input id="search_field" type="text" name="q" placeholder="Search by Customer Name" value="<?php echo htmlspecialchars($q, ENT_QUOTES); ?>" />
		<button class="search_button"></button>
	</div>
</form>

<div id="main_container">

	<h2 class="page_title">Customers</h2>
	
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
					<th>Email</th>
					<th>Address</th>
					<th>City</th>
					<th>Postal Code</th>
					<th>Phone</th>
					<th>Country</th>
					<th>Current Rental</th>
					<th>Total Spent</th>
				</tr>';
		
		// Loop through and output results
		foreach ($results as $key => $value) {
			
			if (isset($_POST['q'])) {
				
				echo '<tr>
						<td>'.htmlspecialchars(ucwords(strtolower($value['customer_name'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['email'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['customer_address'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['city_name'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['postal_code'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['phone'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['country_name'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['current_rental'])), ENT_QUOTES).'</td>
						<td>$'.htmlspecialchars($value['total_spent'], ENT_QUOTES).'</td>
					  </tr>';
			
			} else {
				
				echo '<tr>
						<td>'.htmlspecialchars(ucwords(strtolower($value['customer_name'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['email'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['customer_address'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['city_name'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['postal_code'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['phone'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['country_name'])), ENT_QUOTES).'</td>
						<td>'.htmlspecialchars(ucwords(strtolower($value['current_rental'])), ENT_QUOTES).'</td>
						<td>$'.htmlspecialchars($value['total_spent'], ENT_QUOTES).'</td>
					  </tr>';
					  		  	
					}
			}
		
		echo '</table>';
		//Close Table
	
	
	} else {
		
		if (empty($_POST['q'])) {
			echo '<p class="error_message">Please enter a customer to search for!</p>';
		} else {
		
			// Output no results message
			echo '<p class="error_message">Sorry, no records match your search...</p>';
		}
	}
	
	?>
	
	</div>
</div>

<?php include_once('../templates/footer.php'); ?>