<?php
	header("location:login.php");
	
	if(isset($_SESSION['uid'])){
		header("location: logout.php");
	} else {
		header("location: login.php");
	}
?>