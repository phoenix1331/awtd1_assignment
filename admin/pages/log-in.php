<?php
if (isset($_POST['submit'])) {

$username = $_POST['username'];
$_SESSION['adminUsername'] = $username;
//If logged in go back to previous page
header('Location:'.HOME.'admin/index.php?page=dashboard');
}

?>

  <form action="" method="post">
	  <br>
        <h2>Please log in</h2>
        <input type="text" name="username" placeholder="Username" required autofocus><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button name="submit" type="submit">Sign in</button>
   </form>
   

	