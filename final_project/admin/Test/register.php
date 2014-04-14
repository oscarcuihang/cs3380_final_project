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
	//require_once('log.php');
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
			<p id = "text">Username*</p> <input id = "input_box" type="text" name="user"><br/>
			<p id = 'notify'></p>
			<p id = "text">Password*</p> <input id = "input_box" type="password" name="pass"><br/>
			<p id = "text">Confirm Password*</p> <input id = "input_box" type="password" name="repass"><br/>
			<p id = "text">Email*</p> <input id = "input_box" type="text" name="email"><br/>
			<p id = "text">phone</p> <input id = "input_box" type="text" name="phone"><br/>
			<br/>
			<input id = "input_box" type="submit" value="Register" name="register"><br/>
		</form>
		<?php
			
			if (isset($_POST['register']))
			{
				if ($_POST['user']=='' || ($_POST['pass'] != $_POST['repass']) || $_POST['pass']=='' || $_POST['repass']=='' || $_POST['email'] == '')
				{
					echo "<p id = 'text'>Invalid input, please try again</p>";
				}
				else
				{
					include "../functions.php";
					$result = register($_POST);
					if($result == 0){
						echo "<script>
							var b = document.getElementById('notify').innerHTML;
							b = 'Account already exists.';
						</script>";
					}
					else if($result == 2){
						header("Location: ../../home.php");
					}
				}
			}
			?>
		</div>
	<div>	
</body>
</html>