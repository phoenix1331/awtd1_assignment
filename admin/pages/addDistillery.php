<?php
//If form is submitted enter data into database
if(isset($_POST['submit'])) {
	$name = $_POST['name'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$address3 = $_POST['address3'];
	$address4 = $_POST['address4'];
	$postcode = $_POST['postcode'];
	$fk1_regionName = $_POST['region'];

	$weatherID = getWOEID($postcode);

	if(mysqli_connect_errno()){ 
		echo "connection error! " . mysqli_connect_error(); 
	}else{ 
		$sql = "insert into distillery (name, weatherID, address1, address2, address3, address4, postcode, fk1_regionName) 
			values ('$name','$weatherID','$address1','$address2','$address3','$address4','$postcode','$fk1_regionName')"; 

			mysqli_query($conn, $sql); 
			$affected = mysqli_affected_rows($conn); 
		if(mysqli_error($conn)){ 
			echo "Error: " . mysqli_error($conn) . "<br>"; 
			$affected = "0"; 
			} 
		//echo ($affected . " row(s) inserted"); 
		
		if($affected > 0){
			header('location: index.php?page=distillery');
		}
		 
	} 

}
?>
<h2>Add Distillery</h2>
<p>Please complete the form below to add a distillery. Please check you have entered the postcode correctly as this generates localised data.</p>
  <form action="" method="post">
  <label for="name">Distillery Name</label><br>
        <input type="text" name="name" required autofocus><br>
 <!-- <label for="weather">Weather ID</label><br>
        <input type="text" name="weather" required><br>-->
  <label for="address1">Address 1</label><br>
        <input type="text" name="address1" required><br>
  <label for="address2">Address 2</label><br>
        <input type="text" name="address2" required><br>
  <label for="address3">Address 3</label><br>
        <input type="text" name="address3" required><br>
  <label for="address4">Address 4</label><br>
        <input type="text" name="address4" required><br>
  <label for="postcode">Postcode</label><br>
        <input type="text" name="postcode" required><br>
  <label for="region">Region</label><br>
		<?php getRegions($conn); ?>
        <br><br><button name="submit" type="submit">Submit</button>
   </form>
   
   <div class="clear"></div>