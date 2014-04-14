<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--login.php-->

<?php
	if (($_SERVER['HTTPS']) != 'on')
	{
		$abc = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("location: $abc");
	}
	session_start();
	require_once('log.php');
?>

<!DOCTYPE html>
<html>
<head>
<title>Car Dealer Search</title>
<style></style>
<link rel="stylesheet" type="text/css" href="Style/index.css"/>
<link rel="stylesheet" type="text/css" href="Style/base.css"/>
<link rel="stylesheet" type="text/css" href="Style/search_page.css"/>


</head>

<body>
	<div id="main_content">	
		<img class="picture_cell_top" src="Style/top.jpg"/></br>
		
		<div><nav id="nav_bar">
		<a class="nav_links" id="Register" href="home.php">CLICK HERE TO GO BACK</a>
		</nav></div>
		
		<div id = "login_position">
		<form method="POST" action="login.php">
			<p id = "text">Username*</p> <input id = "input_box" type="text" name="username"><br/>
			<p id = "text">Password*</p> <input id = "input_box" type="password" name="password"><br/>
			<br/>
			<input id = "input_box" type="submit" value="Login" name="submit"><br/>
		</form>
		<?php
	if (isset($_POST['submit']))
	{
		$uname = $_POST['username'];
		$pass= $_POST['password'];
		$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());
		
		$query = 'SELECT * FROM final_project.user_authentication WHERE username = $1 UNION SELECT * FROM final_project.adm_authentication WHERE adm_name = $1';
		pg_prepare($conn, "log_in", $query);
		$result = pg_execute($conn, "log_in", array($uname));
		$row = pg_fetch_assoc($result);
		$salt = $row['salt'];
		$pass_salt = sha1(trim($salt).$pass);
		$ha = $row['password_hash'];
		
		if ($pass_salt != $ha)
		{
		 ?>
			<p id = "text">Invalid username/password</p>
		 <?php
		}
		else 
		{
			//include "log.php";
			$_SESSION['username']= $_POST['username'];
			$_SESSION['log'] = "on";
			log_status($_POST['username'],$_SERVER['REMOTE_ADDR'],'log in');
			//if($row['type'] == 'f')
			//{
				header("location: home.php");
			//}
			//else 
			//{	
				//header("location: admin/");
			//}
		}
	}
?>
		</div>
	</div>	
</body>
</html>