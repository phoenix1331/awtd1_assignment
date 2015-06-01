<?php
/*
* config.php
* 
* database connection
* and constants
*
*/

define("HOME", "http://www.1331.co/dsa/assignment/");

// Database Constants
define("DB_SERVER", "localhost");
define("DB_USER", "phoenix_dsa");
define("DB_PASS", "web1979");
define("DB_NAME", "phoenix_dsa"); 

//Taken from learning material example
//create a connection 
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if(mysqli_connect_errno()){ 
    echo "connection error! " . mysqli_connect_error(); 
} 
else{ 
   // echo "connection OK!"; 
} 

?>