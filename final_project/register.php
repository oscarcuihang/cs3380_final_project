<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--register.php-->

<!DOCTYPE html>
<?php
	if (($_SERVER['HTTPS']) != 'on')
	{
		$abc = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("location: $abc");
	}
	session_start();
	require_once('log.php');
?>
<html>
<head>
<title>Car Dealer Search</title>
<link rel="stylesheet" type="text/css" href="Style/index.css"/>
<link rel="stylesheet" type="text/css" href="Style/base.css"/>
<link rel="stylesheet" type="text/css" href="Style/search_page.css"/>

<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<link rel="stylesheet" href="jq/lavalamp_test.css" type="text/css" media="screen">-->

</head>

<body>
	<div id="main_content">	
		<img class="picture_cell_top" src="Style/top.jpg"/></br>
		<div><nav id="nav_bar">
		<a class="nav_links" href="index.php">CLICK HERE TO GO BACK</a>
		</nav></div>
		<div id = "login_position">
			<p id = "text">* is required!</p>
			<form method="POST" action="register.php">
			<p id = "text">Username*</p> <input id = "input_box" type="text" name="username"><br/>
			<p id = "text">Password*</p> <input id = "input_box" type="password" name="password"><br/>
			<p id = "text">Confirm Password*</p> <input id = "input_box" type="password" name="confirm_password"><br/>
			<p id = "text">Email*</p> <input id = "input_box" type="text" name="email"><br/>
			<p id = "text">phone</p> <input id = "input_box" type="text" name="phone"><br/>
			<br/>
			<input id = "input_box" type="submit" value="Register" name="register"><br/>
		</form>
		<?php
			
			if (isset($_POST['register']))
			{
				if ($_POST['username']=='' || ($_POST['password'] != $_POST['confirm_password']) || $_POST['password']=='' || $_POST['confirm_password']=='' || $_POST['email'] == '')
				{
					echo "<p id = 'text'>Invalid input, please try again</p>";
				}
				else
				{
					$un = $_POST['username'];
					$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());
					$query = 'SELECT username FROM final_project.user_infor WHERE username = $1';
					pg_prepare($conn, "find_user", $query);
					$result = pg_execute($conn, "find_user", array($un));
					if (pg_num_rows($result) == 0)
					{
						$_SESSION["log"] = "on";
						$_SESSION['username']=$_POST['username'];	
						$email = $_POST['email'];
						//$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());
						$salt = mt_rand();
						$pass = $_POST['password'];
						//do the sha1 for salt and password 
						$pwhash =sha1($salt.$pass);
						//insert username to final_project.user_infor
						$query = 'Insert into final_project.user_infor (username, description, email, phone) values ($1, $2, $3, $4)';
						pg_prepare($conn, "user_infor", $query);
						$result = pg_execute($conn, "user_infor", array($_SESSION['username'], "", $email, $_POST['phone']));
						
						//insert username, password_hash and salt to final_project.user_authentication 
						$query_2 = 'Insert into final_project.user_authentication values ($1,$2,$3)';
						pg_prepare($conn, "user_authentication", $query_2);
						$result = pg_execute($conn, "user_authentication", array($_SESSION['username'], $pwhash, $salt));		
						//after register, send the log in information to final_project.log
						log_status($_SESSION['username'],$_SERVER['REMOTE_ADDR'],'register');
						
						//after register, send the log in information to final_project.log
						//log_status($_SESSION['username'],$_SERVER['REMOTE_ADDR'],'log in');
						//send user the home.php
						log_status($_POST['username'],$_SERVER['REMOTE_ADDR'],'log in');
						header("location: home.php");
					}
					else
					{
						echo "<p id = 'text'>Username already been used!</p>";
					}
				}
			}
			?>
		</div>
	<div>	
</body>
</html>