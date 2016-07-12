<?php

include_once('../templates/header.php');

echo '
<h2>'.$record['title'].'</h2>
<p>'.$record['language_name'].'</p>
<p><a href="/movies/public/movies/'.$record['film_id'].'/update" title="Update Movie">Update</a></p>
<p><a href="/movies/public/movies/'.$record['film_id'].'/delete" title="Delete Movie">Delete</a></p>';

include_once('../templates/footer.php');

?>