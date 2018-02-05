<?php
	session_start();	
	unset($_SESSION["dms_uid"]);
	unset($_SESSION["dms_un"]);
	unset($_SESSION["dms_fn"]);
	unset($_SESSION["dms_mn"]);
	unset($_SESSION["dms_ln"]);
	unset($_SESSION["dms_region"]);
	unset($_SESSION["dms_user_type"]);
	header( 'location: login.php?alert='.urlencode("You have successfully logout."));
?>