<?php
		session_start();
		
		$_SESSION = array();
		
		// Eat Cookies
		if(isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		
		// Destroy Session
		session_destroy();
		
		//Go Home
		
		header('Location:'.HOME.'index.php');
?>