<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--update.php-->

<?php
	
	if (($_SERVER['HTTPS']) != 'on')
	{
		$abc = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("location: $abc");
	}
	session_start();
	if(isset($_SESSION['username']) == false)
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
<link rel="stylesheet" type text/css" href="../Style/index.css"/>
<link rel="stylesheet" type="text/css" href="../Style/base.css"/>
<link rel="stylesheet" type="text/css" href="../Style/search_page.css"/>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
<div id="main_content">	
		<img class="picture_cell_top" src="../Style/top.jpg"/></br>
		<div><nav id="nav_bar">
		<a class="nav_links" id="homepage" href="admin.php">Home</a>
		<a class="nav_links" id="Register" href="../logout.php">Logout</a>
		</nav></div>
		<div>
		<br/><p id="text_big">Update the following:</p>
		<?php
			require_once "pgpass.conf";
			$conn = pg_connect(HOST." ".USER." ".DBNAME." ".PASS) or die("Could not connect:" . pg_last_error());
			$query = 'SELECT * FROM final_project.adm_infor WHERE username = $1';
			pg_prepare($conn, "user_up", $query);
			$result = pg_execute($conn, "user_up", array($_SESSION['username']));
			$row = pg_fetch_assoc($result);
		?>
		<form method="POST" action="update.php">
		<p id="text">Username : <?php echo $_SESSION['username'];?> <!--</p> <input id="input_box" type="text" name="username" value="<?php echo $_SESSION['username']?>">-->
		<p id="text">Password</p> <input id="input_box" type="password" name="password"><br/>
		<p id="text">Confirm Password Change</p> <input id="input_box" type="password" name="confirm_password">
		<p id="text">Email</p> <input id="input_box" type="text" name="email" value="<?php echo $row['email'];?>">
		<p id="text">Phone Number</p> <input id="input_box" type="text" name="phone" value="<?php echo $row['phone'];?>">
		<p id="text">User Description</p> <textarea name='description' rows='20' cols='60' placeholder="Enter new description here"></textarea><br/>
			<input id = "input_box" type="submit" value="Update" name="update">
			<input id = "input_box" type="button" value="Cancel" onclick="top.location.href = 'admin.php'">
		</form>
		<?php
			//if statements for password (if written in, if confirm the same)
			if (isset($_POST['update']))
			{
				if (( $_POST['password'] != $_POST['confirm_password']))
				{
					echo "<p id = 'text'>Invalid input, please try again</p>";
				}
				else 
				{	
					$salt = mt_rand();
					$pass = $_POST['password'];
					//do the sha1 for salt and password 
					$pwhash = sha1($salt.$pass);
					//$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());
					//if password updated
					if ( $_POST['password'] != ''){
						$queryp = "UPDATE final_project.adm_authentication SET
								salt = $1,
								password_hash = $2
								WHERE adm_name = $3";
						pg_prepare($conn, "what", $queryp);
						$result = pg_execute($conn, "what", array($salt, $pwhash, $_SESSION['username']));
					}
					
					$query1 = "UPDATE final_project.adm_infor SET 
								email = $1,
								phone = $2,
								description = $3 
								WHERE username = $4";
					pg_prepare($conn, "user_infor_up", $query1);
					$result = pg_execute($conn, "user_infor_up", array($_POST['email'],$_POST['phone'],$_POST['description'],$_SESSION['username']));
					
					/*$query2 = "UPDATE final_project.user_authentication SET 
								salt = $1,
								password_hash = $2,
								WHERE username =$3";
					pg_prepare($conn, "what", $query2);
					$result = pg_execute($conn, "what", array($salt, $pwhash, $_SESSION['username']));
					*/header("location: admin.php");
				}
			}
		?>
		</div>
</div>
</body>
</html>
<?php
}
?>