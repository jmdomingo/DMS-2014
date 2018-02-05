<?php
	include("include/sessionstart.php");//initiate details of user
	include("include/unauthorizedToAdd.php");//Check user if authorized in this page
	include("scripts/dbcon.php");
	ini_set('max_execution_time', 600);//600 seconds equivalent to 10 minutes execution time
	
	if(isset($_GET["id"])){
		$input = true;
		$id = $_GET["id"];
		$queryString = "
			SELECT
			query_id, name, description, nquery , rquery
		FROM
			dms_tbl_query
		WHERE
			query_id = ?
		";
		$query = sqlsrv_query( $Conn, $queryString, array(&$id), array("Scrollable"=>"static"));
		$row = sqlsrv_fetch_array($query);
	} else{
		$input = false;
	}
?>
<html>
	<head>
		<!--<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">-->
		<link rel="shortcut icon" href="images/dms.ico">
		<title>Listahanan Data Monitoring System</title>
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/menu.css" />
		<script type="text/javascript" src="scripts/js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery.dataTables.min.js"></script>
		<?php 
			if(isset($_GET["alert"])):
		?>
		<script type="text/javascript">
			alert("<?php echo htmlentities(urldecode($_GET["alert"])); ?>");
		</script>
		<?php 
			endif; 
		?>
		<script>
			$(document).ready(function() {
				$('#example').dataTable( {
					"scrollY":        "500px",
					"scrollX": true,
					// "scrollCollapse": true,
					"paging":         false
					
				} );
			} );
			
		</script>
	</head>
	<body>
		<?php include("include/header.php");?>
		<div class="container">
			
			<div class="content">
				<?php include("include/identifier.php"); ?>
				<?php include("include/menus.php"); ?>
				<h2>National View</h2>
				<div style = "margin-top:10px; margin-bottom:20px; margin-left:300px;">
					<div class = "" align = "">
						<label style = "">Name:</label></br>
						<textarea class = "textborder" style = "height: 43px; max-height: 43px;max-width: 600px; width: 600px; text-transform:uppercase" disabled = "disabled" 
									name = "name" id = "name"><?php if($input){echo $row["name"];}?></textarea>
					</div>
					<div class = "" align = "">
						<label style = "">Description:</label></br>
						<textarea class = "textborder" style = "height: 55px; max-height: 55px;max-width: 600px; width: 600px; text-transform:uppercase" disabled = "disabled" 
									name = "desc" id = "desc"><?php if($input){echo $row["description"];}?></textarea>
					</div>
					<?php 
						$allow = array(-2);
						if( !in_array( $utypeS , $allow) ) {
							echo'<input type = "hidden" id = "nquery" name = "nquery" value = "'.$row["nquery"].'" />';
						} else{
							echo'
							<div class = "" align = "">
								<label style = "">Regional Query:</label></br>
								<textarea class = "textborder" style = "height: 50px; max-height: 200px; max-width: 600px; width: 600px; text-transform:uppercase" disabled = "disabled" 
											name = "nquery" id = "nquery">'.$row["nquery"].'</textarea>
							</div>
						';
						}
					?>
				</div>				
				<hr size = "1"></hr>
				<div align="right">
				<?php $today = date('l jS \of F Y h:i:s A');
				echo "Date generated as of $today."; ?>
				</div>
				<br>				
					<div align = "center">
					<img id="loading_spinner" src="images/loading37.gif">
					<div id="resultset" align = ''></div>
				</div>
				<script>
					dataString = 'i=' + $("#nquery").val();
					$('#loading_spinner').show();
					$('#resultset').hide();
					$.ajax({
						url: 'view.php',
						type: 'POST',
						data: dataString,
						success: function (data) {
							//on success
							$("#resultset").html(data);
							$('#resultset').show();
							$('#loading_spinner').hide();
						},
						error: function(e) {
							//error catch
						}
					});
				</script>
				<br>
				<div class="identity2" align="center" style="width: 1200;">
					<center>
					<a href="home.php">Back</a>&nbsp;&nbsp;
					<?php 
						$allow = array(-2);
						if( !in_array( $utypeS , $allow) ) {
						} else{		
							echo "<a href = 'editQuery.php?id=".$id."'>Edit</a>&nbsp;&nbsp;&nbsp;";
						}
					?>
					</center>
				</div>				
					<input type = "hidden" id = "updateOrSave" name = "updateOrSave" value = "1" />
					<input type = "hidden" id = "idQuery" name = "idQuery" value = "<?php if($input){ echo $id;}else{echo 0;}?>" />
				
			</div>
		</div>
		<?php include("include/footer.php");?>
	</body>	
</html>
