<?php
	include("include/sessionstart.php");//initiate details of user
	include("include/unauthorizedToAdd.php");//Check user if authorized in this page
	include("scripts/dbcon.php");
	ini_set('max_execution_time', 600);//600 seconds equivalent to 10 minutes execution time
	include("include/validation.php");
	$Errors[] = "";
	$queryString =  strtoupper(trim($_POST["i"]) );
	
	if($queryString == ""){
	} else{
		$Errors = checkQueryN($queryString, $Errors);
	}
	
	if(count($Errors) > 1){
		$text = "";
		foreach($Errors AS $v) {
			$text = "" . $text . " " . $v . "<br>";
		}
		echo "<div style = 'color:red;font-weight:bold;'>TEST ERROR: $text</div>";
	} else {
		echo "<div style = 'font-weight:bold;color:green;'>Query Valid</div>";
	}
	sqlsrv_close( $Conn);
?>

