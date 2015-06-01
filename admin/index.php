<?php
/*
* Main Index.php
* Written by Darren Williams
*

*/

//DB Connect and config
require_once('../includes/config.php');

//Get session data
require_once('includes/session.php');

//Get functions data
require_once('includes/functions.php');



//Get page from URL if set
$page = '';
if(isset($_GET['page'])){
	$page = $_GET['page'];
}

switch($page){

	//Display distillery page
	case 'distillery':
	
		$content = 'distillery.php';
	
	break;
	
	//Display Add Distillery page
	case 'addDistillery':
	
		$content = 'addDistillery.php';
	
	break;
	
	//Display whiskey page
	case 'whiskey':
	
		$content = 'whiskey.php';
	
	break;
	
	//Display Add Whiskey page
	case 'addWhiskey':
	
		$content = 'addWhiskey.php';
	
	break;
	
	//Display login page
	case 'log-in':
	
		$content = 'log-in.php';
	
	break;
	
	//Fire up the logout page
	case 'log-out':
	
		$content = 'log-out.php';
	
	break;
	
	//If empty display dashboard
	default:
		$content = 'dashboard.php';
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