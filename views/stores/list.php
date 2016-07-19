<?php include_once('../templates/header.php'); ?>

	
	<div id="main_container">
	
		<h2 class="page_title">Our Stores</h2>
		<p class="store_intro">Choose one of our stores to view its inventory of films!</p>
		
		<div class="container">
			
		<?php
		
		// Output results if needed
		if ($results) {
		
			echo '<ul class="stores_list">';
			
			// Loop through and output results
			foreach ($results as $key => $value) {
					
				echo '<li>
						<a href="#" title="Store Inventory">'.htmlspecialchars($value['city'], ENT_QUOTES).'</a>
					  </li>';
				
				}
			
			echo '</ul>';
			//Close List
		
			} else {		
				// Output no results message
				echo '<p class="error_message">Sorry, no records match your search...</p>';
			}
		
		
		?>
		
		</div>
	</div>
	
	<?php include_once('../templates/footer.php'); ?>


?>