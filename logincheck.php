<?php
	include("scripts/dbcon.php");
	include("class/db.php");
	
	$Username = $_POST["uname"];
	$Password = $_POST["password"];

	$Query = sqlsrv_query($Conn,
							"SELECT [uid], 
									[user_type], 
									[username], 
									[region], 
									[status],
									[first_name],
									[mid_name],
									[last_name]
								FROM [sys_staff] 
								WHERE username=? 
										AND password=CONVERT( NVARCHAR(32), HashBytes('MD5', ?), 2)",
							array( &$Username, &$Password ) );
	
	
	if( sqlsrv_has_rows($Query) ) {
		sqlsrv_fetch( $Query );
		$Id = sqlsrv_get_field( $Query, 0 );
		$Position = sqlsrv_get_field( $Query, 1 );
		$Username = sqlsrv_get_field( $Query, 2 );
		$Region = sqlsrv_get_field( $Query, 3 );
		$Status = sqlsrv_get_field( $Query, 4 );
		$fn = sqlsrv_get_field( $Query, 5 );
		$mn = sqlsrv_get_field( $Query, 6 );
		$ln = sqlsrv_get_field( $Query, 7 );
		
		echo "Status:" . $Status;
		
		if( $Status == -2 ) {
			header( 'location: login.php?alert='.urlencode("The account you are accessing has been deleted!"));
		} else if( $Status == 0 ) {
			header( 'location: login.php?alert='.urlencode("The account you are accessing is pending for approval."));
		} else if ( $Status == -1 ) {
			header( 'location: login.php?alert='.urlencode("The account you are accessing is locked. Contact the System Administrator to unlock the account."));
		} else if( $Status == 1 ) {
			if( !in_array( $Position, array(-2, 4, 5, 10, 11, 12, 13, 14, 15, 16, 17) ) ) {
							header('location: login.php?alert='.urlencode("You are not allowed to view the page you are accessing.."));
			}
			else{
				session_start();
				
				$DeleteAttempts = sqlsrv_query($Conn,
												"DELETE FROM [dms_login_failed_attempts] WHERE username=?",
												array(&$Username) );
				$_SESSION["dms_uid"] = $Id;
				$_SESSION["dms_un"] = $Username;
				$_SESSION["dms_fn"] = $fn;
				$_SESSION["dms_mn"] = $mn;
				$_SESSION["dms_ln"] = $ln;
				$_SESSION["dms_region"] = $Region;
				$_SESSION["dms_user_type"] = $Position;	
				header("location:home.php?pagenum=1");
			}
		} else {
			sqlsrv_close( $Conn );
			header( 'location: login.php?alert='.urlencode("Error on the account you are accessing. Contact the System Administrator."));
		}
	} else {
		
		$UsernameChecker = sqlsrv_query($Conn, "SELECT uid FROM sys_staff WHERE username=?", array(&$Username) );
		
		if( sqlsrv_has_rows($UsernameChecker) ) {			
			$DeleteAttempts = sqlsrv_query($Conn, "DELETE FROM dms_login_failed_attempts WHERE username=? AND DATEDIFF(mi, datetime_login, CURRENT_TIMESTAMP) >= 30", array(&$Username) );
			$InsertLoginAttempt = sqlsrv_query($Conn, "INSERT INTO dms_login_failed_attempts (username, datetime_login) VALUES ( ?, CURRENT_TIMESTAMP )", array(&$Username) );
			$CheckQuery = sqlsrv_query($Conn, "SELECT COUNT(*) AS attempts FROM dms_login_failed_attempts WHERE username=?", array(&$Username) );
			sqlsrv_fetch( $CheckQuery );
			$NumOfAttempts = sqlsrv_get_field( $CheckQuery, 0 );
			
			
			if( $NumOfAttempts == 1 ) {
				sqlsrv_close( $Conn );
				header( 'location: login.php?alert='.urlencode("Incorrect username and password! You only have 2 login attempts before the account you are accessing will be locked."));
			} else if ( $NumOfAttempts == 2 ) {
				sqlsrv_close( $Conn );
				header( 'location: login.php?alert='.urlencode("Incorrect username and password! You only have 1 login attempt before the account you are accessing will be locked."));
			} else {
				$LockQuery = sqlsrv_query($Conn, "UPDATE sys_staff SET status='-1', last_updated=CURRENT_TIMESTAMP, updated_by='-98' WHERE username=?", array(&$Username) );
				sqlsrv_close( $Conn );
				header( 'location: login.php?alert='.urlencode("Incorrect username and password! Account $Username is now locked. Contact the System Administrator to unlock the account."));
			}
		} else {
			sqlsrv_close( $Conn );
			header( 'location: login.php?alert='.urlencode("Incorrect username or password!"));
		}

		
		//header( 'location: login.php?alert='.urlencode("Incorrect username or password!"));
	}
	
?>