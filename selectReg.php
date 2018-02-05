<?php
	include("include/sessionstart.php");
	include("include/unauthorized.php");//Check user if authorized in the system
	include("scripts/dbcon.php");
	if(isset($_GET["id"])){
		$input = true;
		$id = $_GET["id"];
	}
	else{
		$input = false;
	}
	$queryString = "
		SELECT
			query_id, nquery
		FROM
			dms_tbl_query
		WHERE
			query_id = ?
		";
		$query = sqlsrv_query( $Conn, $queryString, array(&$id));
		$row = sqlsrv_fetch_array($query);
?>
<html>
	<head>
		<!--<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">-->
		<link rel="shortcut icon" href="images/dms.ico">
		<title>Listahanan Data Monitoring System</title>
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/menu.css" />
		<?php 
			if(isset($_GET["alert"])):
		?>
		<script type="text/javascript">
			alert("<?php echo htmlentities(urldecode($_GET["alert"])); ?>");
		</script>
		<?php 
			endif; 
		?>
	</head>
	<body>
		<?php include("include/header.php");?>
		<div class="container">
			
			<div class="content">
				<?php include("include/identifier.php"); ?>
				<?php include("include/menus.php"); ?>
				<h2>Select View</h2>
				<form action="viewRegQuery.php" method="post">
					<div align= "center" class="iden">
						<br><br><br>
						<select id = "region" name = "region">
							<option value = "-2">Please Select Region</option>
							<option value = "01%">Region I</option>
							<option value = "02%">Region II</option>
							<option value = "03%">Region III</option>
							<option value = "04%">Region IV-A</option>
							<option value = "17%">Region IV-B</option>
							<option value = "05%">Region V</option>
							<option value = "06%">Region VI</option>
							<option value = "07%">Region VII</option>
							<option value = "08%">Region VIII</option>
							<option value = "09%">Region IX</option>
							<option value = "10%">Region X</option>
							<option value = "11%">Region XI</option>
							<option value = "12%">Region XII</option>
							<option value = "13%">Region NCR</option>
							<option value = "14%">Region CAR</option>
							<option value = "16%">Region CARAGA</option>
							<option value = "15%">Region ARMM</option>
						</select>
						<input type = "hidden" id = "idQuery" name = "idQuery" value = "<?php if($input){ echo $id;}else{echo 0;}?>" />
						<center>
							<input type = "submit" name="submit" id="subBtn" value="Regional"/>
						</center>
						<br><br><br><br>
						
						<?php 
							if(trim($row["nquery"]) != "") {
								echo "<center><a id='identity' href = 'viewNatQuery.php?id=".$id."'>National</a></center>";
							} else{
								echo "<center><a style='cursor:default;'>National</a></center>";
							}
						?>
					</div>
				</form>	
					
				
			</div>
		</div>
		<?php include("include/footer.php");?>
	</body>	
</html>
