<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--my_page.php-->

<?php
	
	if (($_SERVER['HTTPS']) != 'on')
	{
		$abc = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("location: $abc");
	}
	session_start();
	//require_once('log.php');
	if(isset($_SESSION['type']) != 'admin')
	{
		header("location: ../home.php");
	}
	else 
	{
?>
<!DOCTYPE html>
<html>
<head>
<title>Car Dealer</title>
<style></style>
<link rel="stylesheet" type="text/css" href="../Style/index.css"/>
<link rel="stylesheet" type="text/css" href="../Style/base.css"/>
<link rel="stylesheet" type="text/css" href="../Style/search_page.css"/>
</head>
<body>
	<div id="main_content">	
		<img class="picture_cell_top" src="../Style/top.jpg"/></br>	
			
		<div><nav id="nav_bar">
		<a class="nav_links" id="homepage" href="admin.php">Home</a>
		<a class="nav_links" id="Register" href="../logout.php">Logout</a>
		</nav></div>
		<div id="fill_content1">
			<p id="text_1">
				Hello <?php echo $_SESSION['username']?> ,
			</p>
			<p><a class="nav_links" id = "user_update" href = "update.php">Update MY information</a></p>
			<p><a class="nav_links" id = "user_update" href = "user_car.php">My car information</a></p>
			<p><a class="nav_links" id = "user_update" href = "create_admin.php">Create Admin Account</a>
			<p><a class="nav_links" id = "user_update" href = "user_manipulate.php">Manage User Account</a></p>
			<p><a class="nav_links" id = "user_update" href = "record_manipulate.php">Manage Car Record</a>
		</div>
	</div>
</body>
</html>

<?php
}
?>
