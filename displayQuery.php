<?php
	$Q = $_POST["filter"];
?>

<head>
	<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<script type="text/javascript" src="scripts/js/jquery-1.11.0.js"></script>
</head>
	
<body>
	

<div class="">
	
  <div class="">
		
	<?php		
		echo '<h3 align="center"><em>Query Result</em></h3>';
		// $Q = "SELECT * FROM [tbl_bcc] WHERE [archive] = '0' AND [region_code] LIKE '05%'";
					
		include("scripts/dbcon.php");	
		$stmt = sqlsrv_query($Conn, $Q);
		if( $stmt === false) {
		   die( print_r( sqlsrv_errors(), true));
		}
		
		$numFields = sqlsrv_num_fields( $stmt );
		echo "<br />";
		echo "<table class = 'table'><tr align= 'center' class = 'table'>";
		foreach( sqlsrv_field_metadata( $stmt ) as $fieldMetadata ) {
			// foreach( $fieldMetadata as $name => $value) {
			   // echo "$name: $value<br />";
			// }
			echo "<th width='400' class = 'table'>". $fieldMetadata["Name"]."</th>";
		}
		echo "</tr>";
		while($row = sqlsrv_fetch($stmt) ){
			echo "<tr align= 'center' class = 'table'>";
			for($i = 0; $i < $numFields; $i++) {
				$name = sqlsrv_get_field( $stmt, $i);
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
				
		?>
		
	</div>
	</body>
</html>
