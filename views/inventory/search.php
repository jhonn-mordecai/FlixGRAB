<?php include_once('../templates/header.php'); ?>

<form id="search" action="/movies/public/stores/<?php echo $store_id; ?>/inventory" method="POST">
	<div class="container">
		<input id="search_field" type="text" name="q" placeholder="Search by Movie Title" value="<?php echo htmlspecialchars($q, ENT_QUOTES); ?>" />
		<button class="search_button"></button>
	</div>
</form>

<div id="main_container">
	
	<div class="container">
		
		<h2 class="page_title">Inventory</h2>
		<div class="store_location">
			<p class="location">Location: <?php echo $store_location; ?></p>
			<p><a href="/movies/public/stores" title="Stores">&lt;&lt; Back to All Stores</a></p>
		</div>
		
		<div class="stock_selector">
			<p>
			<?php
			if ($in_stock) {
				echo '<span class="selected">In Stock</span> | <a class="not_selected" href="/movies/public/stores/'.$store_id.'/inventory?out" title="Not In Stock">Not In Stock</a>';
			} else {
				echo '<a class="not_selected" href="/movies/public/stores/'.$store_id.'/inventory" title="In Stock">In Stock</a> | <span class="selected">Not In Stock</span>';
			}
			?>
			</p>
		</div>
		<?php
			
			//IF search
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
			}
		?>
		
		 
					
				<!--Open Table -->
				<table>
					<tr>	
						<th>Inventory ID</th>
						<th>Film</th>
						<th>Actions</th>
					</tr>
				
				
			<?php	
				if ($results) {
				// Loop through and output results
				foreach ($results as $key => $value) {
					if(isset($_POST['q'])) {
						echo '<tr>
								<td>'.(isset($value['inventory_id']) ? $value['inventory_id'] : '--').'</td>
								<td>'.htmlspecialchars(ucwords(strtolower($value['film_title'])), ENT_QUOTES).'</td>';
								if (isset($value['inventory_id']))
									echo '<td><a href="/movies/public/inventory/'.$value['inventory_id'].'/delete" title="Delete Film">Delete</a> | <a href="/movies/public/inventory/create?store='.$store_id.'&movie='.$value['film_id'].'" title="Add to Inventory">Add Another</a></td>';
								else
									echo '<td><a href="/movies/public/inventory/create?store='.$store_id.'&movie='.$value['film_id'].'" title="Add to Inventory">Add</a></td>';
							echo '</tr>';
						}
					}
				
				} elseif
			//
			
		
				// Results per store
				//if 
				($records) {
					
					// Loop through and output results
					foreach ($records as $key => $value) {
							echo '<tr>
									<td>'.(isset($value['inventory_id']) ? $value['inventory_id'] : '--').'</td>
									<td>'.htmlspecialchars(ucwords(strtolower($value['title'])), ENT_QUOTES).'</td>';
									if (isset($value['inventory_id']))
										echo '<td><a href="/movies/public/inventory/'.$value['inventory_id'].'/delete" title="Delete Film">Delete</a> | <a href="/movies/public/inventory/create?store='.$store_id.'&movie='.$value['film_id'].'" title="Add to Inventory">Add Another</a></td>';
									else
										echo '<td><a href="/movies/public/inventory/create?store='.$store_id.'&movie='.$value['film_id'].'" title="Add to Inventory">Add</a></td>';
								echo '</tr>';
					}	
				
				}
		
			?>
		
		</table>
		
	</div>
</div>

<?php include_once('../templates/footer.php'); ?>