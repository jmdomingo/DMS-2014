<?php  
	
	$allowedPending = array(-2, 17);
	if( !in_array( $utypeS , $allowedPending) ) {
		header( 'location: home.php?alert='.urlencode("You are not allowed to view the page you are accessing!!"));
	}

?>