<?php
$search = '';
if(isset($_POST['submit'])) {
$search = $_POST['search'];

}
?>
<h2>Whiskey Search</h2>
<p>You can use our whiskey search to look for a wide range of whiskey's and brand names. The search will return you the latest prices and links to further information, allowing you to purchase you favourite whiskey online.</p>
  <form action="" method="post">
        <input type="text" name="search" placeholder="Whiskey Name" required autofocus><br>
        <button name="submit" type="submit">Search</button>
   </form>
   
   <?php
   if(!empty($search)){
   echo '<br>You searched for <strong>'.$search.'</strong><br><br>';
		whiskeySearch($search);
   }
   ?>
   
   <div class="clear"></div>