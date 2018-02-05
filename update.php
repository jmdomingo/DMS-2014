<?php
	include("include/sessionstart.php");//initiate details of user
	include("include/unauthorizedToAdd.php");//Check user if authorized in this page
	ini_set('max_execution_time', 600);//600 seconds equivalent to 10 minutes execution time
	include("include/validation.php");
	$Errors[] = "";
	$name =  strtoupper(trim($_POST["name"]) );
	$desc = strtoupper( trim($_POST["desc"]) );
	$nquery =  strtoupper(trim($_POST["nquery"]) );
	$rquery =  strtoupper(trim($_POST["rquery"]) );
	$idQuery =  trim($_POST["idQuery"]);
	
	$Errors = checkName($name, $Errors);
	$Errors = checkDesc($desc, $Errors);	
	$Errors = checkQueryR($rquery, "sample", $Errors);	
	$Errors = checkQueryN($nquery, $Errors);
	
	if(count($Errors) > 1){
		$text = "";
		foreach($Errors AS $v) {
			$text = "" . $text . " " . $v . "<br>";
		}
		echo "<div style = 'color:red;font-weight:bold;'>Unable to add, ERROR: $text</div>";
	}
	else {
		include("scripts/dbconAdd.php");
		
		$Query = sqlsrv_query( $Conn, "
			UPDATE
				[dms_tbl_query]
			SET
				[name] = ?,
				[description] = ?,
				[nquery] = ?,
				[rquery] = ?,
				[date_updated] = CURRENT_TIMESTAMP,
				[updated_by] = ?
			WHERE
				[query_id] = ?"
			, array(&$name, &$desc, &$nquery, &$rquery, &$uidS, &$idQuery) );
			
		/*CHECKING IF SUCCESSFULLY SAVED*/
		$checkQuery = sqlsrv_query( $Conn, "SELECT count(1) FROM [dms_tbl_query] WHERE [archive] = '0' AND [name] = ? AND [description] = ? AND [nquery] = ? AND [rquery] = ? AND [query_id] = ?"
				, array(&$name, &$desc, &$nquery, &$rquery, &$idQuery) , array("Scrollable"=>"static"));
		$row_count = sqlsrv_has_rows($checkQuery);
		if(!$row_count){
			echo "Unable to add, ERROR: Contact Administrator";
		}
		else{
			echo "0";
		}
		sqlsrv_close( $Conn);
	}
?>