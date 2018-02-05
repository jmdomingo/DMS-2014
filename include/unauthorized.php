<?php  
	
	$allowedPending = array(-2, 5, 10, 11, 12, 13, 14, 15, 16, 17);
	if( !in_array( $utypeS , $allowedPending) ) {
		header( 'location: login.php?alert='.urlencode("You are not allowed to view the page you are accessing!"));
	}

?>