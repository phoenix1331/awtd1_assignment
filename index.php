<?php

/*
* Main Index.php
* Written by Darren Williams
*

*/

//DB Connect and config
require_once('includes/config.php');

//Get Functions
require_once('includes/mainMapFunction.php');
require_once('includes/functions.php');

//Get session data
require_once('includes/session.php');

//Get distillery and whiskey from URL if set
$distillery = '';
$whiskey = '';

if(isset($_GET['distillery'])){
	$distillery = $_GET['distillery'];
}

if(isset($_GET['whiskey'])){
	$whiskey = $_GET['whiskey'];
}

//Get region from URL if set
$region = '';
$page = '';
if(isset($_GET['region'])){
	$region = $_GET['region'];
	$page = 'show';
}else if(isset($_GET['page'])){
	$page = $_GET['page'];
}

switch($page){

	//If page display page
	case 'show':
		$content = 'singlepage.php';
	break;
	
		
	//Display login page
	case 'log-in':
	
		$content = 'log-in.php';
	
	break;
	
	//Fire up the logout page
	case 'log-out':
	
		$content = 'log-out.php';
	
	break;
	
	//Fire up the search page
	case 'search':
	
		$content = 'search.php';
	
	break;
	
	//Display RSS feed
	case 'rss':
	
		header('location: rss.php');
	
	break;
	
	//Fire up the admin page
	case 'admin':
	
		$content = 'admin.php';
	
	break;
	
	//Display sign-up page
	case 'sign-up':
	
		$content = 'sign-up.php';
	
	break;
	
	//If empty display homepage
	default:
		$content = 'homepage.php';
	break;
}//End Switch

//Start ouput buffer
ob_start();

//Build Page
//Include Header
include_once('includes/header.php');
//Include Menu
include_once('includes/menu.php');
//Include Main Content
include_once('pages/'.$content);
//Include Footer
include_once('includes/footer.php');

//End output buffer
ob_end_flush();

//close the connection 
if($conn){ 
    mysqli_close($conn); 
} 
?>