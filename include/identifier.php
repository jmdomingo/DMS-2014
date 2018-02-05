<div class="identity" align= "right">
	<FONT COLOR="black">
	<?php
		date_default_timezone_set('Asia/Taipei');
		$today = date("F j, Y");
		echo "Today is $today.";
	?>
	You are logged-in as <b><?php echo utf8_encode($unS) ?></b>.
	
	<a href = "logout.php">[Log-out]</a>
	</FONT>
</div>