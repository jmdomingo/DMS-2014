<?php
	include("include/sessionstart.php");//initiate details of user
	include("include/unauthorizedToAdd.php");//Check user if authorized in this page
	include("scripts/dbcon.php");
	ini_set('max_execution_time', 600);//600 seconds equivalent to 10 minutes execution time
	include("include/validation.php");
	
	$Errors[] = "";
	$queryString =  strtoupper(trim($_POST["i"]) );
	$region = trim($_POST["region"]);
	if($queryString == ""){
	} else{
		$Errors = checkQueryR($queryString, $region, $Errors);
	}
	
	if(count($Errors) > 1){
		$text = "";
		foreach($Errors AS $v) {
			$text = "" . $text . " " . $v . "<br>";
		}
		echo "<div style = 'color:red;font-weight:bold;'>RUN ERROR: $text</div>";
	} else {
	
		$queryString = iconv('UTF-8', 'ISO-8859-1', $queryString);
	
		$query = sqlsrv_query( $Conn, $queryString, array(&$region), array("Scrollable"=>"static") );

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
	sqlsrv_close( $Conn);
	
?>