<html>
	<head>
		<link rel="shortcut icon" href="images/dms.ico">
		<title>Listahanan Data Monitoring System</title>
		<link href="menu.css" rel="stylesheet" type="text/css" />		
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/menu.css" />
		<style>
			.login{
				width:500px;
				margin-left:auto;
				margin-right:auto;
			}
			.igitnamokoya{
				margin-top:100px;
				margin-bottom:100px;
			}
			legend{
				background: #A9F5BC;
				color: #0A2A12;
				padding: 5px 10px ;
				font-size: 12px;
				border-radius: 5px;
				box-shadow: 0 0 0 5px #ddd;
				margin-left: 400px;
			}
			.submit{
				pointer:cursor;
			}
			.errorLogin{
				color:red;
				font-weight:bold;
			}
		</style>
		<?php if(isset($_GET["alert"])): ?>
			<script type="text/javascript">
				alert("<?php echo htmlentities(urldecode($_GET["alert"])); ?>");
			</script>
		<?php endif; ?>
		
	</head>
	<body>
		<?php include("include/header.php");?>
		<div  style="height:600px; width:1200px; border: 2px solid; margin-left: auto ; margin-right: auto ;">
			<br><br><br><br><br>
			<div id="container">
			<!--CONTENT PAGE-->
				<form method = "post" action = "logincheck.php">
					<fieldset class = "login">
						<legend>
							<!--<a href = "172.16.10.113/ums">Register here</a>-->
							<a href = "../ums/register.php" target = "_blank">Register here</a>
						</legend>
						<?php
							if(isset($_GET["error"])){
								$error = $_GET["error"];
								if($error == 1){
									echo "
										<div class = 'errorLogin'>
											Invalid username or password!
										</div>
									";
								}
								else if($error == 2){
									echo "
										<div class = 'errorLogin'>
											Invalid username or password!!
										</div>
									";
								}
								else if($error == 3){
									echo "
										<div class = 'errorLogin'>
											Unauthorized Access.
										</div>
									";
								}
							}
						?>
						<table align = "center">
							<tr>
								<td align = 'right'>
									Username:
								</td>
								<td>
									<input type = "text" name = "uname"/>
								</td>
							</tr>
							<tr>
								<td align = 'right'>
									Password:
								</td>
								<td>
									<input type = "password" name = "password"/>
								</td>
							</tr>
						</table>
						<div align = "center">
							<input type = "submit"  value = "Log-In" class = "submit"/>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
		<?php include("include/footer.php");?>
	</body>
</html>
