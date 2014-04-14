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
	if(isset($_SESSION['username']) == false)
	{
		header("location: index.php");
	}
	else 
	{
?>
<!DOCTYPE html>
<html>
<head>
<title>Car Dealer</title>
<style></style>
<link rel="stylesheet" type="text/css" href="Style/index.css"/>
<link rel="stylesheet" type="text/css" href="Style/base.css"/>
<link rel="stylesheet" type="text/css" href="Style/search_page.css"/>
</head>
<body>
	<div id="main_content">	
		<img class="picture_cell_top" src="Style/top.jpg"/></br>	
			
		<div><nav id="nav_bar">
		<a class="nav_links" id="homepage" href="index.php">Home</a>
		<a class="nav_links" id="search_page" href="index_search_page.php">Search</a>
		<a class="nav_links" id="Register" href="logout.php">Logout</a>
		</nav></div>
		<div id="fill_content1">
			<p id="text_1">
				Hello <?php echo $_SESSION['username']?>
			</p>
			<p><a class="nav_links" id="user_update" href="update.php">Update MY information</a></p>
			<p><a class="nav_links" id="user_update" href="user_car.php">My car information</a></p>
		</div>
	</div>
</body>
</html>

<?php
}
?>
