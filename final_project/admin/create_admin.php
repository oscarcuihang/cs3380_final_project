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
<link rel="stylesheet" type="text/css" href="../Style/index.css"/>
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
		<br/><p id="text_big">Enter the following:</p>
		<?php
			require_once "pgpass.conf";
			$conn = pg_connect(HOST." ".USER." ".DBNAME." ".PASS) or die("Could not connect:" . pg_last_error());
			$query = 'SELECT * FROM final_project.adm_infor WHERE username = $1';
			pg_prepare($conn, "user_up", $query);
			$result = pg_execute($conn, "user_up", array($_SESSION['username']));
			$row = pg_fetch_assoc($result);
		?>
		<form method="POST" action="create_admin.php">
		<p id="text">Username : </p> <input id="input_box" type="text" name="username">
		<p id="text">Password</p> <input id="input_box" type="password" name="password" required><br/>
		<p id="text">Confirm Password</p> <input id="input_box" type="password" name="confirm_password" required>
		<p id="text">Email</p> <input id="input_box" type="text" name="email">
		<p id="text">Phone Number</p> <input id="input_box" type="text" name="phone" required>
		<p id="text">User Description</p> <textarea name='description' rows='20' cols='60' placeholder="Enter new description here"></textarea><br/>
			<input id = "input_box" type="submit" value="Submit" name="create">
			<input id = "input_box" type="button" value="Cancel" onclick="top.location.href = 'admin.php'">
		</form>
		<?php
			//if statements for password (if written in, if confirm the same)
			if (isset($_POST['create']))
			{
				$queryFind = "SELECT * FROM final_project.adm_infor WHERE username = $1 UNION SELECT * FROM final_project.user_infor WHERE username = $1";
				pg_prepare($conn, "findifexist", $queryFind);
				$resultLa = pg_execute($conn, "findifexist", array($_POST['username']));
				if (pg_num_rows($resultLa) == 0){
					if (( $_POST['password'] != $_POST['confirm_password']))
					{
						echo "<p id = 'text'>two passwords don't match</p>";
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
							$queryp = "INSERT INTO final_project.adm_infor(username, description, email, phone) VALUES ($1, $2, $3, $4)";
							pg_prepare($conn, "what", $queryp);
							$result = pg_execute($conn, "what", array($_POST['username'], $_POST['description'], $_POST['email'], $_POST['phone']));
						}
					
						$query1 = "INSERT INTO final_project.adm_authentication VALUES($1, $2, $3)";
						pg_prepare($conn, "user_infor_up", $query1);
						$result = pg_execute($conn, "user_infor_up", array($_POST['username'], $pwhash, $salt));
					
						/*$query2 = "UPDATE final_project.user_authentication SET 
									salt = $1,
									password_hash = $2,
									WHERE username =$3";
						pg_prepare($conn, "what", $query2);
						$result = pg_execute($conn, "what", array($salt, $pwhash, $_SESSION['username']));
						*/
						pg_close($conn);
						header("location: admin.php");
					}
				}
				else echo "<p style='color:red;'> Account already exist..Please try a new one</p>";
			}
			pg_close($conn);
		?>
		</div>
</div>
</body>
</html>
<?php
}
?>