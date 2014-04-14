<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--exec.php-->

<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--user_car.php-->

<?php
	if (($_SERVER['HTTPS']) != 'on')
	{
		$abc = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("location: $abc");
	}
	session_start();
	require_once('log.php');
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
			<?php
				if (($_GET['action'] == "insert"))
				{

					// Connect to the database
					/*$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());
					$query = "SELECT * FROM final_project.user_car_infor";
					pg_prepare($conn, "insert_car", $query);
					$result =  pg_execute($conn, "insert_car", array());
					*/
					// Print the table for insertion
					echo "<br/><form method='POST' action='exec.php'>
						<input type='hidden' name='action' value='save_insert' />" ."
						<p id='text'>Please enter the data for your car:". "<br /> 
						<table border='1'>
						<tr><td>Make</td><td><input type='text' name='make' /></td></tr>
						<tr><td>Model</td><td><input type='text' name='model' /></td></tr>
						<tr><td>Price</td><td><input type='text' name='price' /></td></tr>
						<tr><td>city MPG</td><td><input type='text' name='city_MPG' /></td></tr>
						<tr><td>Hway MPG</td><td><input type='text' name='hway_MPG' /></td></tr>
						<tr><td>Doors</td><td><input type='text' name='doors' /></td></tr>
						<tr><td>Engine Type</td><td><input type='text' name='engine' /></td></tr>
						<tr><td>Year</td><td><input type='text' name='year' /></td></tr>
						<tr><td>Status</td><td><input type='text' name='status' /></td></tr>
						<tr><td>Description</td><td><textarea name='description' rows='20' cols='60'>Please enter some description</textarea></td></tr>";
					echo "</form></table>";
			?>
					<p id="text_fill">
					<input type="submit" value="Save">
					<input type="button" value="Cancel" onclick="top.location.href='user_car.php'" />
					</p>
			<?php
				}
				if ($_POST['action'] == 'save_insert')
				{	
					$username = $_SESSION['username'];
					$make = $_POST['make'];
					$model = $_POST['model'];
					$price = $_POST['price'];
					$city_MPG = $_POST['city_MPG'];
					$Hway_MPG = $_POST['hway_MPG'];
					$doors = $_POST['doors'];
					$engine = $_POST['engine'];
					$year = $_POST['year'];
					$status = $_POST['status'];
					$description = $_POST['description'];
					
					$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());
					$query = "INSERT INTO final_project.used_car_infor(username, make, model, price, city_mpg, hway_mpg, doors, engine, car_year, status, description) 
							VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11)";
					pg_prepare($conn, "insert_car", $query);
					
					$result = pg_execute($conn, "insert_car", array($username,$make,$model,$price,$city_MPG,$Hway_MPG,$doors,$engine,$year,$status,$description));
					log_status($_SESSION['username'],$_SERVER['REMOTE_ADDR'],'insert a car');
					header("location: user_car.php");
					
				}
				$carid = $_POST['ci'];
				if ($_POST['action'] == 'remove')
				{		
					$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());
					$query = "DELETE FROM final_project.used_car_infor WHERE car_id = $1";
					pg_prepare($conn, "delet_car", $query);
					$result = pg_execute($conn, "delet_car", array($carid));
			?>
					<p id="text">Your car has been deleted</p>
					<a class="nav_links" id="" href="user_car.php">Back to My Page</a>
			<?php
				log_status($_SESSION['username'],$_SERVER['REMOTE_ADDR'],'delete a car');
				}
				if ($_POST['action'] == 'edit')
				{
					$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());
					$query = "SELECT * FROM final_project.used_car_infor WHERE car_id = $1";
					pg_prepare($conn, "edit_car", $query);
					$result = pg_execute($conn, "edit_car", array($carid));
					while($row = pg_fetch_array($result))
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
						$tempid = $status_update = $row['car_id'];
						//$description = $row['description'];
						echo "<br/><form method='POST' action='' id='form' name='form'>"."
						<p id='text'>Update your car". "<br /> 
						<table border='1'>
						<input type = 'hidden' name = 'id' value = $tempid>
						<tr><td>Make</td><td><input type='text' name='make' value = $make_update /></td></tr>
						<tr><td>Model</td><td><input type='text' name='model' value = $model_update /></td></tr>
						<tr><td>Price</td><td><input type='text' name='price' value = $price_update /></td></tr>
						<tr><td>city MPG</td><td><input type='text' name='city_MPG' value = $city_MPG_update /></td></tr>
						<tr><td>Hway MPG</td><td><input type='text' name='hway_MPG' value = $Hway_MPG_update /></td></tr>
						<tr><td>Doors</td><td><input type='text' name='doors' value = $doors_update /></td></tr>
						<tr><td>Engine Type</td><td><input type='text' name='engine' value = $engine_update /></td></tr>
						<tr><td>Year</td><td><input type='text' name='year' value = $car_year_update /></td></tr>
						<tr><td>Status</td><td><input type='text' name='status' value = $status_update /></td></tr>
						<tr><td>Description</td><td><textarea name='description' rows='20' cols='60'>Please enter your car's update description</textarea></td></tr>";
						echo "</form>";
					}
					echo "<input type='submit' name='submit_update' id='submit' value='Save'>";
					echo "<input type='button' value='Cancel' onclick=\"top.location.href ='user_car.php'\">";
					
				}
				
				if (isset($_POST['submit_update']))
				{	
					$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());
					$query = "UPDATE final_project.used_car_infor SET
								make = $1,
								model = $2,
								price = $3,
								city_mpg = $4,
								hway_mpg = $5,
								doors = $6,
								engine = $7,
								car_year = $8,
								status = $9,
								description = $10
								WHERE car_id = $11";
					pg_prepare($conn, "edit_car", $query);
					$result = pg_execute($conn, "edit_car", array($_POST['make'],$_POST['model'],$_POST['price'],$_POST['city_MPG'],
																	$_POST['hway_MPG'],$_POST['doors'],$_POST['engine'],$_POST['year'],
																	$_POST['status'],$_POST['description'],$_POST['id']));
			?>
					<p id="text">Your car has been update</p>
					<a class="nav_links" id="" href="user_car.php">Back to My Page</a>
			<?php
				log_status($_SESSION['username'],$_SERVER['REMOTE_ADDR'],'update your car');
				}
			?>
			
						
		<div>
		</div>
	</div>
</body>
</html>
<?php
}
?>
