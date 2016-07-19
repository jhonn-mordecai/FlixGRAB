<?php include_once('../templates/header.php'); ?>

<div id="main_container">

	<h2 class="page_title">Stores</h2>
	<p class="store_intro">Choose one of our stores to view its inventory of films!</p>
	
	<div class="container">
		
		<ul class="stores_list">
		
		<?php
		
			foreach ($stores as $key => $value) {
				
				echo '<li>
						<p><a class="store_link" href="/movies/public/stores/'.$value['store_id'].'/inventory">'.htmlspecialchars($value['city'], ENT_QUOTES).'</a></p>
						<p>'.htmlspecialchars($value['address'].', '.$value['city'].', '.$value['country'], ENT_QUOTES).'</p>
					  </li>';
				
			}
			
		?>
		
		</ul>
		
	</div>
</div>

<?php include_once('../templates/footer.php'); ?>