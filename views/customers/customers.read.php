<?php

include_once('../templates/header.php');

echo '
<h2>'.$record['first_name'].' '.$record['last_name'].'</h2>
<ul>
<li>'.$record['store_id'].'</li>
<li>'.strtolower($record['email']).'</li>
<li>'.$record['address_id'].'</li>
<li>'.$record['active'].'</li>
</ul>
<p><a href="/movies/public/actors/'.$record['customer_id'].'/update" title="Update Customer">Update</a></p>
<p><a href="/movies/public/actors/'.$record['customer_id'].'/delete" title="Delete Customer">Delete</a></p>';

include_once('../templates/footer.php');

?>