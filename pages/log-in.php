<?php
if (isset($_POST['submit'])) {

$username = $_POST['username'];
$_SESSION['username'] = $username;
//If logged in go back to previous page
header('Location:'.$_SESSION['backTwo']);
}

?>

  <form action="" method="post">
	  <br>
        <h2>Please log in</h2>
        <input type="text" name="username" placeholder="Username" required autofocus><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button name="submit" type="submit">Sign in</button>
   </form>
   

	