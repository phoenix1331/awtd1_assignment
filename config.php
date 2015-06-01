<?php
/*
* config.php
* 
* database connection
* and constants
*
*/

define("HOME", "http://www.cems.uwe.ac.uk/~d46-williams/dsa/");

// Database Constants
define("DB_SERVER", "mysql5");
define("DB_USER", "fet12039763");
define("DB_PASS", "6r53AEN7");
define("DB_NAME", "fet12039763"); 

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