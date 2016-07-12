<form action="<?php echo $endpoint; ?>" method="POST">
	<p>Are you sure you want to delete this record?</p>
	<input type="hidden" name="confirm" value="1" />
	<button type="submit">Confirm</button>
</form>