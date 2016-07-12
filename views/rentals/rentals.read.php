<?php

include_once('../templates/header.php');

echo '
<h2>'.$record['first_name'].' '.$record['last_name'].'</h2>
<p><a href="/movies/public/actors/'.$record['actor_id'].'/update" title="Update Actor">Update</a></p>
<p><a href="/movies/public/actors/'.$record['actor_id'].'/delete" title="Delete Actor">Delete</a></p>';

include_once('../templates/footer.php');

?>