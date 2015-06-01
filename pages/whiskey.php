<?php

/*
* Comments form and code by Tom Pepperell
*
*/

if(isset($_POST['submit'])) { 
  //if(!addslashes($_POST['username'])) die('<u>ERROR:</u> you must enter a username to add a comment.'); 
  //if(!addslashes($_POST['comment']))  die('<u>ERROR:</u> cannot add comment if you do not enter one!?'); 
  //if(!addslashes($_POST['votes']))  die('<u>ERROR:</u> cannot add vote if you do not enter one!?'); 



//try to prevent multiple posts and flooding... 
$c = "SELECT * from `comments` WHERE ip = '".$_SERVER['REMOTE_ADDR']."'"; 
  $c2 = mysqli_query($conn,$c); 
     while($c3 = mysqli_fetch_object($c2)) { 
      $difference = time() - $c3->time; 
     if($difference < 1) die('<u>ALERT:</u> '.$c3->username.', You have already commented earlier; if you have a question, try the forums!<BR>'); 
      } //end while 

//add comment 
$q ="INSERT INTO comments (date, time, fk1_username, fk2_name, ip, comment, votes)  
VALUES ('".$_POST['date']."','".$_POST['time']."', '".$_POST['username']."','".$_POST['whiskey']."', '".$_SERVER['REMOTE_ADDR']."', '".addslashes(htmlspecialchars(nl2br($_POST['comment'])))."', '".addslashes(htmlspecialchars($_POST['votes']))."')"; 

     echo($q . "<br>"); 
        mysqli_query($conn, $q); 
        $affected = mysqli_affected_rows($conn); 
    if(mysqli_error($conn)){ 
        echo "Error: " . mysqli_error($conn) . "<br>"; 
        $affected = "0"; 
        } 
    echo ($affected . " row(s) inserted");

//refresh page so they can see new comment 

header('Location:' . $_SERVER['HTTP_REFERER']); 

}  ?>

<div id="left">
<?php

	//Get breadcrumbs
	breadcrumbs($region,$distillery,$whiskey);

echo '<h1>'.$whiskey.'</h1>'; 


	//Get whiskey data
	whiskeyScrape($conn,$whiskey);
?>
<h2>Other Whiskeys</h2>
<?php
	//Get other whiskeys for this distillery
	getOtherWhiskeys($conn,$region,$distillery,$whiskey);

?>

</div>
<div id="right">
<h2>Comments</h2>
	<?php
	/*
	* Comments and Comments form by Tom Pepperell
	*
	*/  

	//connect to your database 

	//query comments for this page of this article 
	$inf = "SELECT * FROM `comments` WHERE fk2_name = '".$whiskey."'"; 
	 $info = mysqli_query($conn,$inf); 
		 if(!$info) die(mysql_error()); 
		 
		 
		 
	   $info_rows = mysqli_num_rows($info); 
	if($info_rows > 0) { 
	   echo '<table width="100%" class="commenttable">'; 
		
	 while($info2 = mysqli_fetch_object($info)) { 
	echo '<tr><td class="comment-box"><strong>'.stripslashes($info2->fk1_username).'</strong><br>';  
	echo stripslashes($info2->comment).'<br><br>'; 


	$star = stripslashes($info2->votes);

	switch($star){
	case 1:
	echo "<img src='img/1star.png' height='25'><br>";
	break;
	case 2:
	echo "<img src='img/2star.png' height='25'><br>";
	break;
	case 3:
	echo "<img src='img/3star.png' height='25'><br>";
	break;
	case 4:
	echo "<img src='img/4star.png' height='25'><br>";
	break;
	case 5:
	echo "<img src='img/5star.png' height='25'><br>";
	break;
	}

	echo '</td>'; 
	echo '</tr>'; 
	//echo '<td></td><td><div align="right"> '.date('jS M y', $info2->time).'<div></td>';
	//echo '</tr>'; 

	}//end while 
	echo '</table>'; 
	//echo '<hr width="100%" noshade>'; 
	} else echo 'No comments for this page. Feel free to be the first. <br><br>'; 
	/*
	if($info2->'votes'=1) {
	echo '<img src="1star.png>';
	}
	*/

	
	//Check if logged in
	if(!loggedIn()){

	echo 'Please <a href="index.php?page=log-in">log in</a> to post comments.';

	 }else{ ?>


	<form name="comments" action="" method="post"> 

	<input type="hidden" name="page" value="<? echo($_SERVER['REQUEST_URI']); ?>"> 
	<input type="hidden" name="date" value="<? echo(date("F j, Y.")); ?>"> 
	<input type="hidden" name="time" value="<? echo(time()); ?>"> 
	<input type="hidden" name="whiskey" value="<?php echo $whiskey; ?>">
	<input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">

	<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
	   <tr>  
		  
		   <td>Username:<br><input name="user" class="form" type="text" required size="30" value="<?php echo $_SESSION['username']; ?>" disabled></td> 
	   </tr> 
	 
	 
	<tr><td>Comment:</td></tr>	
		  <tr>
		  <td><textarea name="comment" required cols="50" rows="10" wrap="VIRTUAL"></textarea></td> 
		</tr> 
		<tr> 
		  <td>Rate the whiskey :</td> 
		  </tr><tr>
		  <td><input type="radio" name="votes" value="1">1
		  <input type="radio" name="votes" value="2" >2
		  <input type="radio" name="votes" value="3" >3
		  <input type="radio" name="votes" value="4" >4
		  <input type="radio" name="votes" value="5" >5
		  </td> 
		</tr> 
		<tr>
		  <td class="buttons"><input type="submit" name="submit" value="Submit">
		  <input type="reset" value="clear"> 
		  </td> 
		</tr> 
	  </table> 
	</form> 

	<?php } ?>
</div>
<div class="clear"></div>