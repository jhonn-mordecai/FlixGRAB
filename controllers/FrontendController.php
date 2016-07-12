<?php


	class FrontendController {
	
		public function home() {
			
			include_once('../templates/header.php');
			
			echo '<div id="home_container">
					<div class="container">
					<h2>Movie Mania!</h2>
						<p class="intro">Visit FlixGRAB\'s sections to search for movies, actors and more!</p>
						<div class="coming_soon">
						
							<h3>Coming Soon!</h3>
							<div class="poster_container">
								<img src="../public/img/idad.jpg" alt="Movie Poster 1" />
								<img src="../public/img/mog2.jpg" alt="Movie Poster 2" />
							</div>
							
							<p class="intro">The hottest releases always at your fingertips!</p>
						</div>
					</div>
				 </div>';
			
			include_once('../templates/footer.php');
		}
		
	}	

?>