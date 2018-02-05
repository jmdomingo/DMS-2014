<?php
	session_start();
	if(!isset($_SESSION["dms_fn"])){
		header("location:login.php");
	}
	else{
		$uidS = $_SESSION["dms_uid"];
		$unS = $_SESSION["dms_un"];
		$fnS = $_SESSION["dms_fn"];
		$mnS = $_SESSION["dms_mn"];
		$lnS = $_SESSION["dms_ln"];
		$regionS = $_SESSION["dms_region"];
		$utypeS = $_SESSION["dms_user_type"];			
	}
?>