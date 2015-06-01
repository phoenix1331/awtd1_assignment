<?php
	session_start();
	
	function loggedInAdmin() {
		return isset($_SESSION['adminUsername']);
	}
	
	function confirmLoggedInAdmin() {
		if (!loggedInAdmin()) {
			header('Location:'.HOME.'admin/index.php?page=log-in');
		}
	}
?>
