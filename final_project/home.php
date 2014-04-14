<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--home.php-->

<?php
	if (($_SERVER['HTTPS']) != 'on')
	{
		$abc = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("location: $abc");
	}
	session_cache_limiter('private, must-revalidate');
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Car Dealer</title>
<style></style>
<link rel="stylesheet" type="text/css" href="Style/index.css"/>
<link rel="stylesheet" type="text/css" href="Style/base.css"/>
<link rel="stylesheet" type="text/css" href="Style/search_page.css"/>

<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="js/cars.js"></script>-->
<!--<link rel="stylesheet" href="jq/lavalamp_test.css" type="text/css" media="screen">-->


</head>
<body>
	<div id="main_content">	
		<img class="picture_cell_top" src="Style/top.jpg"/></br>	
	<nav id="nav_bar">
	<?php
		if($_SESSION['log'] != 'on'){
	?>
		<a class="nav_links" id="Login" href="login.php">Login</a>
		<a class="nav_links" id="homepage" href="index.php">Home</a>
		<a class="nav_links" id="Register" href="register.php">Register</a>
	<?php
		} else {
	?>
		<a class="nav_links" id="myPage" href="my_page.php">My Page</a>
		<a class="nav_links" id="Home" href="index.php">Home</a>
		<a class="nav_links" id="Logout" href="logout.php">Log Out</a>
	<?php
		}
	?>
	</nav>
	<div id="title_content">
		
		<h2 id="title"> CJLLR Car Dealer</h2>
	</div>
		<div id="fill_content">
			<?php
				if($_SESSION['log'] == 'on')
				{
			?>
					<p id="text_fill">
					Hello <?php echo $_SESSION['username']?>
					</p>
			<?php
				}
			?>
			<p id="text_fill">
			Looking for a new car? Looking for a used car? We have them all! We are the CJLLR Car Dealership and we're here to help find your perfect car!
			You can find what you like and what you want! And you can get it at the lowest Price!
			</p>
			<div id="picture_table">
				<img class="picture_cell_top" src="Style/jeep.jpg"/>
				<img class="picture_cell_bottom" src="Style/A6.jpg"/>
				<img class="picture_cell_bottom" src="Style/F150.jpg"/>
			</div>
			<p id="text_fill">
			What does CJLLR stand for?  It is the combination of the efforts of its 5 creators,
			and thusly stands for each creator's last name.
			</p>
			
			<p id="text_fill">
				<a class="nav_links" id="Search" href="index_search_page.php">Start a new search NOW!</a>
			</p>
		</div>
		<div id="results">
		</div>
	</div>
</body>
</html>