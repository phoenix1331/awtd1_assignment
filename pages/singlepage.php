<?php
//find out which page to display
$page = '';
if(isset($_GET['distillery'])){
	$page = 'distillery';
}
if(isset($_GET['distillery']) && isset($_GET['whiskey'])){
	$page = 'whiskey';
}

//Set content to display
switch($page){

	//Display whiskey page
	case 'whiskey':
	
		include('whiskey.php');
	
	break;
	
	//Display distillery page
	case 'distillery':
	
		include('distillery.php');
	
	break;
	
	//Display region page
	default:
	
		include('region.php');
	
	break;



} //End switch
?>


