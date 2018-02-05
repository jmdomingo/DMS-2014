<?php
	//Validation routine for input of name
	function checkName($text, $Errors){
		$iChars = str_split("ñ ÑabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-()',");

		if( strlen($text) < 10 ) {
			$Errors[] = "Name should at least be 10 characters";
		} else {
		
			$s1 = str_split($text);
			if (array_diff($s1, $iChars) ) {
				$Errors[] = "Special character in name is not allowed";
			}
		
		}
		return $Errors;
	}
	//Validation routine for input of description
	function checkDesc($text, $Errors){
		$iChars = str_split("ñ ÑabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890/%@-.(),'");
		
		if( strlen($text) < 10 ) {
			$Errors[] = "Description should at least be 10 characters";
		} else {
			$s1 = str_split( $text );
			if (array_diff($s1, $iChars) ) {
				$Errors[] = "Special character in description is not allowed";
			}
		}
		return $Errors;
	}
	//Validation routine for Query statement under National
	function checkQueryN($text, $Errors){
		include("scripts/dbcon.php");
		if($text == ""){
		} else {
			$iChars = str_split("ñÑ%' \r\n\t abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789/0\".<>-,_()[]=");		
			$s1 = str_split( $text );
			if ( array_diff($s1, $iChars) ) {
				$Errors[] = "Special character in query statement under National is not allowed";
			} else {
				if(strpos($text, 'UPDATE') !== false) {
					$Errors[] = "Unapproved word detected in Query statement under National";
				} else if(strpos($text, 'DELETE') !== false) {
					$Errors[] = "Unapproved word detected in Query statement under National";
				} else if(strpos($text, 'INSERT') !== false) {
					$Errors[] = "Unapproved word detected in Query statement under National";
				} else if(strpos($text, 'CREATE') !== false) {
					$Errors[] = "Unapproved word detected in Query statement under National";
				} else if(strpos($text, 'ALTER') !== false) {
					$Errors[] = "Unapproved word detected in Query statement under National";
				} else if(strpos($text, 'DROP') !== false) {
					$Errors[] = "Unapproved word detected in Query statement under National";
				} else {
					$queryCheck = sqlsrv_query( $Conn, $text, array() , array("Scrollable"=>"static"));
					
					if( $queryCheck === false ) {
						$Errors[] = "Query statement in National is invalid";
						if( ($errors = sqlsrv_errors() ) != null) {
							foreach( $errors as $error ) {
								$Errors[] = "<b>SQLSTATE:</b> ".$error[ 'SQLSTATE'];
								$Errors[] = "<b>Code:</b> ".$error[ 'code'];
								$Errors[] = "<b>message: </b>".$error[ 'message'];
							}
						}
					}
				}
			}
		}
		return $Errors;
	}
	//Validation for Query statement under Regional
	function checkQueryR($text, $reg, $Errors){
		include("scripts/dbcon.php");
		if($text == ""){
			$Errors[] = "Query statement in Regional is required";
		} else {
			$iChars = str_split("ñÑ%' \r\n\t abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789/0\".<>-,_()[]?=");		
			$s1 = str_split( $text );
			if (array_diff($s1, $iChars) ) {
				$Errors[] = "Special character in query statement under Regional is not allowed";
			} else {
				if(strpos($text, 'UPDATE') !== false) {
					$Errors[] = "Restricted  word detected in Query statement under Regional";
				} else if(strpos($text, 'DELETE') !== false) {
					$Errors[] = "Restricted  word detected in Query statement under Regional";
				} else if(strpos($text, 'INSERT') !== false) {
					$Errors[] = "Restricted  word detected in Query statement under Regional";
				} else if(strpos($text, 'CREATE') !== false) {
					$Errors[] = "Restricted  word detected in Query statement under Regional";
				} else if(strpos($text, 'ALTER') !== false) {
					$Errors[] = "Restricted  word detected in Query statement under Regional";
				} else if(strpos($text, 'DROP') !== false) {
					$Errors[] = "Restricted  word detected in Query statement under Regional";
				} else {						
					$queryCheck = sqlsrv_query( $Conn, $text, array(&$reg) , array("Scrollable"=>"static"));					
					if( $queryCheck === false ) {
						$Errors[] = "Query statement in Regional is invalid";
						if( ($errors = sqlsrv_errors() ) != null) {
							foreach( $errors as $error ) {
								$Errors[] = "<b>SQLSTATE:</b> ".$error[ 'SQLSTATE'];
								$Errors[] = "<b>Code:</b> ".$error[ 'code'];
								$Errors[] = "<b>message: </b>".$error[ 'message'];
							}
						}
					} else if(!strpos($text, '?') ) {
						$Errors[] = "? was not detected in Query statement under Regional";
					}
				}
			}
		}
			return $Errors;		
	}
?>