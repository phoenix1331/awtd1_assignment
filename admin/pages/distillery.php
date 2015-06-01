<table class="table">
<tr>
<th>Name</th>
<th>Region</th>
<th>Whiskey Count</th>
</tr>
<?php
	getDistilleries($conn);
?>
</table>
<br>
<a href="index.php?page=addDistillery" title="Add Distillery">Add Distillery</a>