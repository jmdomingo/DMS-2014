<?php
	include("include/sessionstart.php");
	$id = $_GET["id"];
		
	include("scripts/dbcon.php");
	$Query = sqlsrv_query( $Conn, "UPDATE [dms_tbl_query]
				SET
					[archive] = '1',
					[deleted_by] = ?,
					[date_deleted] = CURRENT_TIMESTAMP
				WHERE
					[query_id] = ?"
					, array(&$uidS, &$id) );
								
	/*CHECKING IF SUCCESSFULLY DELETED*/
	$checkQuery = sqlsrv_query( $Conn, "SELECT [query_id] FROM [tbl_query] WHERE [archive] = '1' "
				, array() , array("Scrollable"=>"static"));
	$row_count = sqlsrv_has_rows($checkQuery);
	if(!$row_count){
		header("location: home.php?alert=".urlencode("Unable to delete, ERROR: Contact Administrator"));
	} else {
		header("location: home.php?&alert=".urlencode("Query is successfully deleted"));
	}
	
?>