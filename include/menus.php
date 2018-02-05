<ul class="menuTemplate4 decor4_1">
	<li>
		<a href="home.php?pagenum=1">Home</a>
	</li>
	<li class="separator"></li>
	<?php
		if($_SESSION["user_type"] == -2) {
	?>
		<li>
			<a href="addQuery.php?">Add</a>
		</li>
	<?php
		}
	?>
	<li class="separator"></li>
</ul>

