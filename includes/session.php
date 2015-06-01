<?php
	session_start();
	
	//Set last page
	$_SESSION['backOne'] = $_SERVER['HTTP_REFERER'];
	if($_SESSION['backOne'] != $_SESSION['hold']){
		//Hold value
		$_SESSION['backTwo'] = $_SESSION['hold'];
		$_SESSION['hold'] = $_SESSION['backOne'];
	}
	//Set last but one page
	//$_SESSION['backTwo'] = $_SESSION['backOne'];
	
	function loggedIn() {
		return isset($_SESSION['username']);
	}
	
	/*function confirmLoggedIn() {
		if (!loggedIn()) {
			return
		}
	}*/
?>
