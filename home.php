<?php
	include("include/sessionstart.php");//initiate details of user
	include("include/unauthorized.php");//Check user if authorized in the system
	include("scripts/dbcon.php");
	ini_set('max_execution_time', 600);//600 seconds equivalent to 10 minutes execution time
	include("include/pagination.php");
?>
<html>
	<head>
		<link rel="shortcut icon" href="images/dms.ico">
		<title>Listahanan Data Monitoring System</title>
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/menu.css" />
		<link rel="stylesheet" type="text/css" href="css/table.css" />
		<script type="text/javascript" src="scripts/js/addQuery.js"></script>
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
		
		<div class="container">
		
			<?php include("include/header.php");?>
		
			<div class="content">
				<?php include("include/identifier.php"); ?>
				<?php include("include/menus.php"); ?>
				<h2>Home</h2>
				<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">			
				
					<div class="" style="align:right; width:600px" >
						<fieldset>							
							<label class ="" width = ""> Search by:</label>
							<input type="radio" name="category" id="radio1" value="1" />Id
							<input type="radio" name="category" id="radio2" value="2" checked="checked"/>Report Name
							<input type = "text" id = "filter" name="filter" style="width: 240px;" onfocus="setValue(this)" onblur="setValue(this)" value=""/>
							<input type="submit" name="submit" value="Search" style="float:right"/>
						</fieldset>
					</div>
				</form>
				<div class="results">
				<?php
				$Pagenum = 1;
				if ( isset($_GET["pagenum"]) ) {
					$Pagenum = $_GET["pagenum"];
				}
				
				if($regionS != "000000000"){	
					
					$queryString = "
						SELECT
							query_id, name, description, nquery , rquery
						FROM
							dms_tbl_query
						WHERE
							archive = '0' AND rquery IS NOT NULL
					";
					$query = sqlsrv_query( $Conn, $queryString, array(), array("Scrollable"=>"static"));
					
						$Fields = "";
					
					if( sqlsrv_has_rows($query) ) {
									
						//Query Builder
						if( isset( $_GET["submit"] ) ) {
						
							$Fields .= "category=" . $_GET["category"];
							
							switch( $_GET["category"] ) {
								case 1:
									// $name = GetSQLValueString( trim($_GET["filter"]), "text", 1 );
									$name = trim($_GET["filter"]);
									$queryString .= " AND query_id LIKE '" . trim($_GET["filter"] . "'");
									$Fields .= "&name=" . $name;
									break;
								case 2:
									// $name = GetSQLValueString( trim($_GET["filter"]), "text", 1 );
									$name = trim($_GET["filter"]);
									$queryString .= " AND name LIKE '%" . trim($_GET["filter"] . "%'");
									$Fields .= "&name=" . $name;
									break;
							
							
							}
						} else {
							if( isset($_GET["category"]) ) {
								$Fields .= "category=" . $_GET["category"];
								
								switch( $_GET["category"] ) {
								case 1:
									// $subject = GetSQLValueString( trim($_GET["filter"]), "text", 1 );
									$name = trim($_GET["name"]);
									$queryString .= " AND query_id LIKE '" . trim($_GET["subject"] . "'");
									$Fields .= "&name=" . $name;
									break;
								case 2:
									// $subject = GetSQLValueString( trim($_GET["filter"]), "text", 1 );
									$name = trim($_GET["name"]);
									$queryString .= " AND name LIKE '%" . trim($_GET["subject"] . "%'");
									$Fields .= "&name=" . $name;
									break;
								}
							}						
						}
							
						$query = sqlsrv_query($Conn, $queryString, array(), array("Scrollable"=>'static') );
									
						$num_rows = sqlsrv_num_rows($query);
						
						
						if( $num_rows ) {
							$ResultsPerPage = 15;
							$LastPage = ceil($num_rows/$ResultsPerPage); 
							if ($Pagenum < 1) { 
								$Pagenum = 1; 
							} else if ($Pagenum > $LastPage) { 
								$Pagenum = $LastPage; 
							}
							
						$Page = getPage( $query, $Pagenum, $ResultsPerPage );
						
						echo "<div align='center'>";
							echo "";
							echo "
									<font size='2px'>$num_rows result/s</font>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								 ";
							echo "
									<font size='2px'>Page $Pagenum of $LastPage</font>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  ";
							echo "";
							
							//echo $_SERVER['PHP_SELF'];
							
							if($Pagenum != 1){
								echo " <a href='" . $_SERVER['PHP_SELF'] . "?pagenum=1&$Fields'><img src='images/nav_first.gif' width='20px' height='20px' border='1px' onmouseover=\"this.src='images/nav_first_sel.gif'\" onmouseout=\"this.src='images/nav_first.gif'\" /></a> ";
								echo " ";
								$Previous = $Pagenum-1;
								echo "<a href='" . $_SERVER['PHP_SELF'] . "?pagenum=$Previous&$Fields'><img src='images/nav_prev.gif' width='20px' height='20px' border='1px' onmouseover=\"this.src='images/nav_prev_sel.gif'\" onmouseout=\"this.src='images/nav_prev.gif'\" /></a> ";
							} else {
								echo "<img src='images/nav_first.gif' width='20px' height='20px' border='1px' /> ";
								echo " ";
								$Previous = $Pagenum-1;
								echo "<img src='images/nav_prev.gif' width='20px' height='20px' border='1px' /> ";
							}
							
							if($Pagenum != $LastPage) {
								$Next = $Pagenum+1;
								echo " <a href='" . $_SERVER['PHP_SELF'] . "?pagenum=$Next&$Fields'><img src='images/nav_next.gif' width='20px' height='20px' border='1px' onmouseover=\"this.src='images/nav_next_sel.gif'\" onmouseout=\"this.src='images/nav_next.gif'\" /></a> ";

								echo " ";

								echo " <a href='" . $_SERVER['PHP_SELF'] . "?pagenum=$LastPage&$Fields'><img src='images/nav_last.gif' width='20px' height='20px' border='1px' onmouseover=\"this.src='images/nav_last_sel.gif'\" onmouseout=\"this.src='images/nav_last.gif'\" /></a> ";
							} else {
								$Next = $Pagenum+1;

								echo "<img src='images/nav_next.gif' width='20px' height='20px' border='1px' /> ";
								echo " ";
								echo "<img src='images/nav_last.gif' width='20px' height='20px' border='1px' />";
							}
							
							echo "</div>";
							echo "
							<div class='' align='center'>
								<table>
									<tr>
										<th width='40'>ID</th>
										<th width='400'>Name</th>
										<th width='400'>Description</th>
									</tr>
									";
								foreach($Page as $row) {
								
									
									echo "
									<tr style = 'cursor:pointer;' onClick='window.location.href=\"viewQuery.php?id=" . $row[0] . "\"'>
										<td>" . $row[0] . "</td>
										<td>" . $row[1] . "</td>
										<td>" . $row[2] . "</td>
									</tr>
									";
								}
								echo "</table>
						</div>";
						} else {						
						echo "<br /><p align='center'>No Result</p>";
						}
					} else {					
						echo "<br /><p align='center'>No Result</p>";
					}
				
				} else {
					$queryString = "
						SELECT
							query_id, name, description, nquery , rquery
						FROM
							dms_tbl_query
						WHERE
							archive = '0'
					";
					$query = sqlsrv_query( $Conn, $queryString, array(), array("Scrollable"=>"static"));
					
						$Fields = "";
					
					if( sqlsrv_has_rows($query) ) {
									
						//Query Builder
						if( isset( $_GET["submit"] ) ) {
						
							$Fields .= "category=" . $_GET["category"];
							
							switch( $_GET["category"] ) {
								case 1:
									// $subject = GetSQLValueString( trim($_GET["filter"]), "text", 1 );
									$name = trim($_GET["filter"]);
									$queryString .= " AND query_id LIKE '" . trim($_GET["filter"] . "'");
									$Fields .= "&name=" . $name;
									break;
								case 2:
									// $name = GetSQLValueString( trim($_GET["filter"]), "text", 1 );
									$name = trim($_GET["filter"]);
									$queryString .= " AND name LIKE '%" . trim($_GET["filter"] . "%'");
									$Fields .= "&name=" . $name;
									break;
							}
						} else {
							if( isset($_GET["category"]) ) {
								$Fields .= "category=" . $_GET["category"];
								
								switch( $_GET["category"] ) {
								case 1:
									// $name = GetSQLValueString( trim($_GET["filter"]), "text", 1 );
									$name = trim($_GET["name"]);
									$queryString .= " AND query_id LIKE '" . trim($_GET["name"] . "'");
									$Fields .= "&name=" . $name;
									break;
								case 2:
									// $name = GetSQLValueString( trim($_GET["filter"]), "text", 1 );
									$name = trim($_GET["name"]);
									$queryString .= " AND name LIKE '%" . trim($_GET["name"] . "%'");
									$Fields .= "&name=" . $name;
									break;
								}
							}
						}
							
						$query = sqlsrv_query($Conn, $queryString, array(), array("Scrollable"=>'static') );
									
						$num_rows = sqlsrv_num_rows($query);
						
						
						if( $num_rows ) {
							$ResultsPerPage = 15;
							$LastPage = ceil($num_rows/$ResultsPerPage); 
							if ($Pagenum < 1) { 
								$Pagenum = 1; 
							} else if ($Pagenum > $LastPage) { 
								$Pagenum = $LastPage; 
							}
							
						$Page = getPage( $query, $Pagenum, $ResultsPerPage );
						
						echo "<div align='center'>";
							echo "";
							echo "
									<font size='2px'>$num_rows result/s</font>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								 ";
							echo "
									<font size='2px'>Page $Pagenum of $LastPage</font>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								  ";
							echo "";
							
							//echo $_SERVER['PHP_SELF'];
							
							if($Pagenum != 1){
								echo " <a href='" . $_SERVER['PHP_SELF'] . "?pagenum=1&$Fields'><img src='images/nav_first.gif' width='20px' height='20px' border='1px' onmouseover=\"this.src='images/nav_first_sel.gif'\" onmouseout=\"this.src='images/nav_first.gif'\" /></a> ";
								echo " ";
								$Previous = $Pagenum-1;
								echo "<a href='" . $_SERVER['PHP_SELF'] . "?pagenum=$Previous&$Fields'><img src='images/nav_prev.gif' width='20px' height='20px' border='1px' onmouseover=\"this.src='images/nav_prev_sel.gif'\" onmouseout=\"this.src='images/nav_prev.gif'\" /></a> ";
							} else {
								echo "<img src='images/nav_first.gif' width='20px' height='20px' border='1px' /> ";
								echo " ";
								$Previous = $Pagenum-1;
								echo "<img src='images/nav_prev.gif' width='20px' height='20px' border='1px' /> ";
							}
							
							if($Pagenum != $LastPage) {
								$Next = $Pagenum+1;
								echo " <a href='" . $_SERVER['PHP_SELF'] . "?pagenum=$Next&$Fields'><img src='images/nav_next.gif' width='20px' height='20px' border='1px' onmouseover=\"this.src='images/nav_next_sel.gif'\" onmouseout=\"this.src='images/nav_next.gif'\" /></a> ";

								echo " ";

								echo " <a href='" . $_SERVER['PHP_SELF'] . "?pagenum=$LastPage&$Fields'><img src='images/nav_last.gif' width='20px' height='20px' border='1px' onmouseover=\"this.src='images/nav_last_sel.gif'\" onmouseout=\"this.src='images/nav_last.gif'\" /></a> ";
							} else {
								$Next = $Pagenum+1;

								echo "<img src='images/nav_next.gif' width='20px' height='20px' border='1px' /> ";
								echo " ";
								echo "<img src='images/nav_last.gif' width='20px' height='20px' border='1px' />";
							}
							
							echo "</div>";
							echo "
							<div class='' align='center'>
								<table>
									<tr>
										<th width='40'>ID</th>
										<th width='400'>Name</th>
										<th width='400'>Description</th>
										<th>Report</th>";
							if($utypeS == -2) {
								echo "<th>Delete</th>";
								echo "<th>Edit</th>";
							}
							echo "</tr>
									";
								foreach($Page as $row) {								
									
									echo "
									<tr>
										<td>" . $row[0] . "</td>
										<td>" . $row[1] . "</td>
										<td>" . $row[2] . "</td>
									";
									if($row[3] == ""){
										echo "<td>
											<div align= 'center' style = 'cursor:pointer;' onClick='window.location.href=\"selectReg.php?id=" . $row[0] . "\"'>
												<img src='images/non.png' alt='' name='Insert_logo' width='40' height='20' id='Insert_logo' />
											</div>
										</td>";
									} else {
										echo "<td>
											<div align= 'center' style = 'cursor:pointer;' onClick='window.location.href=\"selectReg.php?id=" . $row[0] . "\"'>
												<img src='images/check1.png' alt='' name='Insert_logo' width='40' height='20' id='Insert_logo' />
											</div>
										</td>";
									}

									if($utypeS == -2) {
										echo "<td>
											<div align= 'center'><a href = 'deleteQueryProcess.php?id=" . $row[0] . "'
											onClick='return confirm(\"Are you sure you want to delete report ID " . $row[0] . "?\");'>" .
												"<img src='images/x.svg' alt='' name='Insert_logo' width='40' height='20' id='Insert_logo' /></a>
											</div>
										</td>";
										
										echo "<td>
											<div align= 'center'><a href = editQuery.php?id=" . $row[0] . "
											onClick='return confirm(\"Are you sure you want to edit id # " . $row[0] . "?\");'>" .
												"<img src='images/edit2.png' alt='' name='Insert_logo' width='20' height='20' id='Insert_logo' /></a>
											</div>
										</td>";
									}
									
									echo "</tr>";
								}
								echo "</table>
						</div>";
						} else {						
						echo "<br /><p align='center'>No Result</p>";
						}
					} else {					
						echo "<br /><p align='center'>No Result</p>";
					}
				}
				?>
				</div>	
			</div>
		</div>
		<?php include("include/footer.php");?>
	</body>
</html>