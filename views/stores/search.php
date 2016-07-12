
<?php include_once('../templates/header.php'); ?>


<!--<form id="search" action="/movies/public/stores/" method="POST">
	<div class="container">
		<input id="search_field" type="text" name="q" placeholder="Search by Movie Title" value="<?php echo htmlspecialchars($q, ENT_QUOTES); ?>" />
		<button class="search_button"></button>
	</div>
</form> -->

<div id="main_container">

	<h2 class="page_title">Our Stores</h2>
	
	<div class="container">
		
	<?php
	
	// Output results if needed
	if ($results) {
	
		//Open Table
		echo '<table>
				<tr>	
					<th>Store</th>
					<th>Inventory</th>
				</tr>';
		
		// Loop through and output results
		foreach ($results as $key => $value) {
				
			echo '<tr>
					<td> Location '.htmlspecialchars(ucwords(strtolower($value['store_id'])), ENT_QUOTES).'</td>
					<td><a href="/movies/public/stores/'.$value['store_id'].'/" title="See Inventory">See Store Inventory</a> </td>
				  </tr>';
			
			}
		
		echo '</table>';
		//Close Table
	
	} else {		
		// Output no results message
		echo '<p class="error_message">Sorry, no records match your search...</p>';
	}
	
	
	?>
	
	</div>
</div>
<?php include_once('../templates/footer.php'); ?>