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
	
	$Errors = checkName($name, $Errors);
	$Errors = checkDesc($desc, $Errors);	
	$Errors = checkQueryR($rquery, "sample", $Errors);		
	$Errors = checkQueryN($nquery, $Errors);
	
	$nquery = iconv('UTF-8', 'ISO-8859-1', $nquery);
	$rquery = iconv('UTF-8', 'ISO-8859-1', $rquery);
	
	if(count($Errors) > 1){
		$text = "";
		foreach($Errors AS $v) {
			$text = "" . $text . " " . $v . "<br>";
		}
		echo "<div style = 'color:red;font-weight:bold;'>Unable to add, ERROR: $text</div>";
	}
	else {
		include("scripts/dbconAdd.php");
		
		$queryCheck = sqlsrv_query( $Conn, "SELECT [query_id] FROM [dms_tbl_query] WHERE [archive] = '0' AND [name] = ?"
						, array(&$name) , array("Scrollable"=>"static"));
		$rows = sqlsrv_has_rows($queryCheck);
		if($rows){
			echo "<div style = 'color:red;font-weight:bold;'>Unable to add, name duplication detected</div>";
		}
		else{
			$Query = sqlsrv_query( $Conn, "INSERT INTO [dms_tbl_query]
					( [name], [description], [nquery], [rquery], [added_by],
					[date_added], [updated_by], [date_updated], [deleted_by], [date_deleted],
					[archive])
				VALUES 	(?, ?, ?, ?, ?,
					CURRENT_TIMESTAMP, ?, CURRENT_TIMESTAMP, '-98', '1900-01-01 00:00:00.000',
					'0')"
					, array(&$name, &$desc, &$nquery, &$rquery, &$uidS, &$uidS) );

		
								
					
			/*CHECKING IF SUCCESSFULLY SAVED*/
			$checkQuery = sqlsrv_query( $Conn, "SELECT [query_id] FROM [dms_tbl_query] WHERE [archive] = '0' AND [name] = ?"
						, array(&$name) , array("Scrollable"=>"static"));
			
			$row_count = sqlsrv_has_rows($checkQuery);
			$row = sqlsrv_fetch_array($checkQuery);
			$id = $row['query_id'];
			if(!$row_count){
				/*echo "INSERT INTO [dms_tbl_query]
					( [name], [description], [nquery], [rquery], [added_by],
					[date_added], [updated_by], [date_updated], [deleted_by], [date_deleted],
					[archive])
				VALUES 	('$name', '$desc', '$nquery', '$rquery', '$uidS',
					CURRENT_TIMESTAMP, '$uidS', CURRENT_TIMESTAMP, '-98', '1900-01-01 00:00:00.000',
					'0')";*/
				echo "Unable to add, ERROR: Contact Administrator1";
			}
			else{	
				echo $id;
			}
		}
		sqlsrv_close( $Conn);
	}
?>