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
				<li><a href="index.php" title="Scottish Distilleries">Home</a></li>
				<?php
					//For each region show links
					getMenuLinks($conn);
				?>
				<li><a href="index.php?page=search" title="Whiskey Search">Whiskey Search</a></li>
			</ul>
		</nav>