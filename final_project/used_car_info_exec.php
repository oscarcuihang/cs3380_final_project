<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--used_car_info_exec.php-->

<?php
	if (($_SERVER['HTTPS']) != 'on')
	{
		$abc = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("location: $abc");
	}
	session_start();
	require_once('log.php');
	/*if(isset($_SESSION['username']) == false)
	{
		header("location: index.php");
	}
	else 
	{*/
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
			
		<div>
		<?php
		if (isset($_SESSION['username']) == false)
		{ 
		?>	
			<nav id="nav_bar">
			<a class="nav_links" id="Login" href="login.php">Login</a>
			<a class="nav_links" id="bighome" href="home.php">Home</a>
			<a class="nav_links" id="Register" href="register.php">Register</a>
			</nav>
		<?php
		} 
		else
		{
		?>
			<nav id="nav_bar">
			<a class="nav_links" id="myPage" href="my_page.php">My Page</a>
			<a class="nav_links" id="home" href="home.php">Home</a>
			<a class="nav_links" id="Logout" href="logout.php">Logout</a>
			</nav>
		<?php
		}
		?>
		</div>
		<div id="fill_content1">
			<?php
				$carid = $_POST['ci'];
				$uname =  $_POST['un'];
				if ($_POST['action'] == 'info')
				{
					$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());	
					//$query = "SELECT * FROM final_project.user_infor, final_project.used_car_infor WHERE user_infor.username = used_car_infor.username AND car_id = $1";
					$query2 = "SELECT user_infor.email, user_infor.phone, user_infor.description AS desc1,
								used_car_infor.make, used_car_infor.model, used_car_infor.model, used_car_infor.price,
								used_car_infor.city_mpg, used_car_infor.hway_mpg, used_car_infor.doors,used_car_infor.engine,
								used_car_infor.car_year, used_car_infor.status, used_car_infor.description AS desc2
								FROM final_project.user_infor, final_project.used_car_infor
								WHERE user_infor.username = used_car_infor.username AND car_id = $1";
								
					pg_prepare($conn, "print", $query2);
					$result = pg_execute($conn, "print", array($carid));
					while(($row = pg_fetch_array($result)))
					{	
						$make_update = $row['make'];
						$model_update = $row['model'];
						$price_update = $row['price'];
						$city_MPG_update = $row['city_mpg'];
						$Hway_MPG_update = $row['hway_mpg'];
						$doors_update = $row['doors'];
						$engine_update = $row['engine'];
						$car_year_update = $row['car_year'];
						$status_update = $row['status'];
						$description1 = $row['desc2'];
						$email = $row['email'];
						$phone = $row['phone'];
						$description2 = $row['desc1'];
						echo "<p id='text'>About this car". "<br /> 
						<table border='1'>
						<tr><td>This car belongs to</td><td>".$uname."</td></tr>
						<tr><td>Make</td><td>".$make_update."</td></tr>
						<tr><td>Model</td><td>".$model_update."</td></tr>
						<tr><td>Price</td><td>".$price_update."</td></tr>
						<tr><td>city MPG</td><td>".$city_MPG_update."</td></tr>
						<tr><td>Hway MPG</td><td>".$Hway_MPG_update."</td></tr>
						<tr><td>Doors</td><td>".$doors_update."</td></tr>
						<tr><td>Engine Type</td><td>".$engine_update."</td></tr>
						<tr><td>Year</td><td>". $car_year_update ."</td></tr>
						<tr><td>Status</td><td>". $status_update ."</td></tr>
						<tr><td>Description</td><td>".$description1."</td></tr>";
						echo "</table></p>";
						
						echo "<p id='text'>About this user". "<br /> 
						<table border='1'>
						<tr><td>This car belongs to</td><td>".$uname."</td></tr>
						<tr><td>email</td><td>".$email."</td></tr>
						<tr><td>phone</td><td>".$phone."</td></tr>
						<tr><td>Description</td><td>".$description2."</td></tr>";
						echo "</table></p>";
					}
					/*
			$query2 = "SELECT * FROM final_project.user_infor WHERE username = $1";
					pg_prepare($conn, "info", $query2);
					$result2 = pg_execute($conn, "info", array($uname));
					while($row2 = pg_fetch_array($result2))
					{
						$un = $row2['username'];
						$email = $row2['email'];
						$phone = $row2['phone'];
						$description2 = $row2['description'];
						echo "<p id='text'>About this user". "<br /> 
						<table border='1'>
						<tr><td>This car belongs to</td><td>".$un."</td></tr>
						<tr><td>email</td><td>".$email."</td></tr>
						<tr><td>phone</td><td>".$phone."</td></tr>
						<tr><td>Description</td><td>".$description2."</td></tr>";
						echo "</table></p>";
					}*/
					
				}
			?>
			<a class="nav_links" id="Search" href="index_search_page.php">Back</a>
						
		<div>
		</div>
	</div>
</body>
</html>

