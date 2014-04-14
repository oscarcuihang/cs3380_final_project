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
		
		$deter = 0;
		$query1 = "SELECT * FROM final_project.user_authentication WHERE username = $1";
		pg_prepare($conn, "user", $query1);
		$result1 = pg_execute($conn, "user", array($uname));
		$query2 = "SELECT * FROM final_project.adm_authentication WHERE adm_name = $1";
		pg_prepare($conn, "admin", $query2);
		$result2 = pg_execute($conn, "admin", array($uname));
		if(pg_num_rows($result1) > 0){
			$row = pg_fetch_array($result1);
			$salt = $row['salt'];
			$ha = $row['password_hash'];
			$pass_salt = sha1(trim($salt).$pass);
			$deter = 1;
		} else if(pg_num_rows($result2) > 0){
			$row = pg_fetch_array($result2);
			$salt = $row['salt'];
			$ha = $row['password_hash'];
			$pass_salt = sha1(trim($salt).$pass);
			$deter = 2;
		} else $deter = 0;
		
		if($deter != 0){
			if ($pass_salt != $ha)
			{
				//echo $ha."<br>";
				//echo $pass_salt;
			?>
				<p id = "text">Invalid username/password</p>
			<?php
			}
			else 
			{
				//include "log.php";
				$_SESSION['username']= $_POST['username'];
				$_SESSION['log'] = "on";
				if($deter == 1)
					$_SESSION['type'] = "user";
				else if($deter == 2)
					$_SESSION['type'] = "admin";
				log_status($_POST['username'],$_SERVER['REMOTE_ADDR'],'log in');
				pg_close($conn);
				if($deter == 1)
					header("Location: home.php");
				else if($deter == 2)
					header("Location: admin/admin.php");
			}
		} else echo "<p id = 'text'>No account exists</p>";
		pg_close($conn);
	}
?>
		</div>
	</div>	
</body>
</html>