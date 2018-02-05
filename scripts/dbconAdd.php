<?php

	
	 $Server = "#";
     $connectionInfo = array( "Database"=>"nhts_sql", "UID"=>"adm_db_user", "PWD"=>"adm_db_pass");
     $Conn = sqlsrv_connect( $Server, $connectionInfo);
	   
	if( !$Conn ) {
		header( 'location: login.php?alert='.urlencode("Error connecting to the database. Contact your NITO for instructions."));
	}

?>