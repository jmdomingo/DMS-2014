<?php
	include("include/dbcon.php");
	
	$queryString = $_POST["i"];
	$query = sqlsrv_query( $Conn, $queryString, array(), array("Scrollable"=>"static") );

	if( $query === false ) {
		if( ($errors = sqlsrv_errors() ) != null) {
			echo "<div style = 'color:red;'>";
			foreach( $errors as $error ) {
				echo "<b>SQLSTATE:</b> ".$error[ 'SQLSTATE']."<br />";
				echo "<b>Code:</b> ".$error[ 'code']."<br />";
				echo "<b>message: </b>".$error[ 'message']."<br />";
			}
			echo "</div>";
		}
	}
	else{
		echo'
		<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
			</head>
		</html>';
		$numRows = sqlsrv_num_rows($query);
		if($numRows > 0){
			$num_fields = sqlsrv_num_fields( $query );
			echo "<table class = 'table'><tr align= 'center' class = 'table'>";
			foreach( sqlsrv_field_metadata( $query ) as $fieldMetadata ) {
				
				echo "<th width='400' class = 'table'>". $fieldMetadata["Name"]."</th>";
			}
			echo "</tr>";
			while($row = sqlsrv_fetch($query) ){
				echo "<tr align= 'center' class = 'table'>";
				for($i = 0; $i < $num_fields; $i++) {
					$name = sqlsrv_get_field( $query, $i);
					$type = gettype($name);	
					$date = "";	
						if($type == 'object'){									
							$_arr = is_object($name) ? get_object_vars($name) : $name;
							foreach ($_arr as $key => $val) {
								$val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
								$date = $date . $val;
							}
							echo "<td width='400' class = 'table'>". substr($date, 0, 19) ."<br /></td>";
						} else {
							echo "<td class = 'table'>". $name ."</td>";
						}		
				}
				echo "</tr>";
			}
			echo "</table>";
		}
		else{
			echo "<div>No result!</div>";
		}
	}
?>