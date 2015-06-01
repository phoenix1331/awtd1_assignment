<?php
//Get weather URL
$url = getWeatherURL($conn,$distillery);
//Get Distillery Map
getDistilleryMap($conn,$url,$distillery);

?>
<div id="regionMap"></div>
<p>Click marker to view address.</p>
<div id="left">
<?php 
//Get breadcrumbs
breadcrumbs($region,$distillery,$whiskey);

echo '<h1>'.$distillery.' Distillery</h1>';
?>

<?php
	//Get wiki information
	wikiScrape($distillery);
	//Get address
	echo getAddress($conn,$distillery);
?>
<h2>Whiskey Links</h2>
<p>Please click a link below to view one of our whiskeys.</p>
<?php
	//Get Whiskey Links
	getWhiskeys($conn,$region,$distillery);
?>


<?

	
	
	
	
?>
</div>
<div id="right">
<h2>Local Weather</h2>
<?php
	
	//Get distillery data
	getDistilleriesData($conn,$region,$distillery);

	
?>
<div id="chart_div"></div>


</div>
<div class="clear"></div>