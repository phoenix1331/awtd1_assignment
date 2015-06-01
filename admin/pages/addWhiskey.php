<?php
//If form is submitted enter data into database
if(isset($_POST['submit'])) {
	$name = $_POST['name'];
	$url = $_POST['url'];
	$fk1_id = $_POST['distillery'];

	if(mysqli_connect_errno()){ 
		echo "connection error! " . mysqli_connect_error(); 
	}else{ 
		$sql = "insert into whiskey (name, fk1_id, url) 
			values ('$name','$fk1_id','$url')"; 

			mysqli_query($conn, $sql); 
			$affected = mysqli_affected_rows($conn); 
		if(mysqli_error($conn)){ 
			echo "Error: " . mysqli_error($conn) . "<br>"; 
			$affected = "0"; 
			} 
		//echo ($affected . " row(s) inserted"); 
		
		if($affected > 0){
			header('location: index.php?page=whiskey');
		}
		 
	} 

}
?>
<h2>Add Whiskey</h2>
<p>Please complete the form below to add a whiskey. The external link needs to be the web page on <a href="http://www.awardrobeofwhisky.com" target="_blank">awardrobeofwhiskey.com</a> for your entered whiskey.</p>
  <form action="" method="post">
  <label for="name">Whiskey Name</label><br>
        <input type="text" name="name" required autofocus><br>
  <label for="url">External Link</label><br>
        <input type="text" name="url" required><br>
  <label for="distillery">Distillery</label><br>
		<?php getDistilleryList($conn); ?>
        <br><br><button name="submit" type="submit">Submit</button>
   </form>
   
   <div class="clear"></div>