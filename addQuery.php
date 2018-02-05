<?php
	include("include/sessionstart.php");
	include("include/unauthorizedToAdd.php");//Check user if authorized in this page
	include("scripts/dbcon.php");	
?>
<html>
	<head>
		<!--<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">-->
		<link rel="shortcut icon" href="images/dms.ico">
		<title>Listahanan Data Monitoring System</title>
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/menu.css" />		
		<link rel="stylesheet" type="text/css" href="css/table.css" />
		<script type="text/javascript" src="scripts/js/jquery-1.11.0.js"></script>
		<script type="text/javascript">
			function clearText() {
				document.getElementById("name").value = "";
				document.getElementById("desc").value = "";
				document.getElementById("rquery").value = "";
				document.getElementById("nquery").value = "";
				document.getElementById("region").value = -2;
			}
			function home(x) {
				window.location.assign("home.php?pagenum=1&alert=New query has been saved successfully! Report ID is " + x + ".")
			}
		</script>
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
				
				<h2>Add</h2>
				<div style = "margin-top:10px; margin-bottom:20px; margin-left:300px;">
					<div class = "" align = "">
						<label style = "">Name:</label>
						</br>
						<label style = "color: red">*</label><textarea class = "textborder" style = "max-height: 43px; height: 43px; max-width: 600px; width: 600px; text-transform:uppercase" 
									maxlength = "200" name = "name" id = "name"></textarea>
					</div>
					<div class = "" align = "">
						<label style = "">Description:</label></br>
						<label style = "color: red">*</label><textarea class = "textborder" style = "max-height: 55px; height: 55px; max-width: 600px; width: 600px; text-transform:uppercase" 
									maxlength = "500" name = "desc" id = "desc"></textarea>
					</div>
				</div>
				<div style=" float: left; margin-left:50px;">
					<div class = "" align = "left">
						<label style = "">National Query:</label>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button id = "ntest" class = "button">Test</button>
						<button id = "nrun" class = "button">Run</button>
						</br>
						<textarea class = "textborder" style = "max-height: 170px;max-width: 500px; width: 500px; height:170px; text-transform:uppercase" maxlength = "8000"
									 name = "nquery" id = "nquery" onfocus="leaveChange()" onblur="leaveChange()"></textarea>			
					</div>
				</div>
				<div style="float: left; margin-left:50px;">
					<div>
						<label style = "color: red">*</label><label style = "">Regional Query:</label>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select id = "region">
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
						<button id = "rtest" class = "button">Test</button>
						<button id = "rrun" class = "button">Run</button>
						</br>
						<textarea class = "textborder" style = "max-height: 170px;max-width: 500px; width: 500px; height:170px; text-transform:uppercase" maxlength = "8000"
									 name = "rquery" id = "rquery" onfocus="leaveChange()" onblur="leaveChange()"></textarea><br>
						<div style="width:549px"><em><font size="2">
						NOTE: <br />1. Region code is required to be added in the Query in WHERE clause. <br />(Eg. WHERE REGION LIKE ?) <br />2. To test or run, please select a region.
						</font></em></div>
					</div>
				</div>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				<div align="center" style="width: 1200px">
					<center>						
						<button id = "clear" class = "button" onclick="javascript:clearText();">Clear</button>
						<button id = "save" class = "button">Save</button>
					</center>
				</div>
				<hr size = "1"></hr>				
				<div align = "center">
					<img id="loading_spinner" src="images/loading37.gif">
					<div id="resultset" align = '' style='width: 1000px;  height: 550px; border:0px solid black; overflow-x:scroll; margin: 0 auto;'></div>
				</div>
			</div>
			<div id="sideright"></div>
			
		</div>
		<?php include("include/footer.php");?>
	</body>
	<script>
		$(document).ready( function() {
			$("#nrun").on( "click" ,function() {			
				dataString = 'i=' + $("#nquery").val();
				$('#loading_spinner').show();
				$('#resultset').hide();
				$.ajax({
					url: 'run.php',
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
			});	
		});	
		$(document).ready( function() {
			$("#rrun").on( "click" ,function() {				
				dataString = 'i=' + $("#rquery").val() + '&region=' + $("#region").val();
				$('#loading_spinner').show();
				$('#resultset').hide();
				$.ajax({
					url: 'runr.php',
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
			});
		});
		$(document).ready( function() {
			$("#ntest").on( "click" ,function() {				
				dataString = 'i=' + $("#nquery").val();
				$.ajax({
					url: 'test.php',
					type: 'POST',
					data: dataString,
					success: function (data) {
						//on success
						$("#resultset").html(data);
					},
					error: function(e) {
						//error catch
					}
				});
			});
		});
		$(document).ready( function() {
			$("#rtest").on( "click" ,function() {
				dataString = 'i=' + $("#rquery").val() + '&region=' + $("#region").val();
				$.ajax({
					url: 'testr.php',
					type: 'POST',
					data: dataString,
					success: function (data) {
						//on success
						$("#resultset").html(data);
					},
					error: function(e) {
						//error catch
					}
				});
			});
		});
		$(document).ready( function() {
			$("#save").on( "click" ,function() {				
				dataString = 'name=' + $("#name").val() + '&desc=' + $("#desc").val() + '&nquery=' + $("#nquery").val() + '&rquery=' + $("#rquery").val();
				$.ajax({
					url: 'save.php',
					type: 'POST',
					data: dataString,
					success: function (data) {
						//on success						
						var x = data;
						if(Math.round(x) == x){
							home(x);
						} else {
							$("#resultset").html(data);
						}
					},
					error: function(e) {
						//error catch
					}
				});
			});	
		});
	</script>
</html>
