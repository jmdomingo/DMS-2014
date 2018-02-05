<?php

	
	 $Server = "#";
     $connectionInfo = array( "Database"=>"nhts_sql_jp", "UID"=>"vwr_db_user", "PWD"=>"vwr_db_pass");
     $Conn = sqlsrv_connect( $Server, $connectionInfo);
	   
	if( !$Conn ) {
		header( 'location: login.php?alert='.urlencode("Error connecting to the database. Contact your NITO for instructions."));
	}

?>