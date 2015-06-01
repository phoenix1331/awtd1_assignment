<?php
/*
* Main menu.php
*
*
*
*/
?>


		<nav>
			<ul>
	         <?php if(loggedInAdmin()){ ?>
				<li><a href="<?php echo HOME; ?>index.php" title="View Site" target="_blank">View Site</a></li>
				<li><a href="index.php" title="Admin">Dashboard</a></li>
				<li><a href="index.php?page=distillery" title="Distillery">Distillery</a></li>
				<li><a href="index.php?page=whiskey" title="Whiskey">Whiskey</a></li>
		    <?php } ?>
			</ul>
		</nav>
