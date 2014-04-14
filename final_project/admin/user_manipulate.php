<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--index_search_page.php-->

<!DOCTYPE html>
<?php
	if (($_SERVER['HTTPS']) != 'on')
	{
		$abc = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("location: $abc");
	}	
	//session_cache_limiter('private, must-revalidate');
	session_start();
?>

<html>
<head>
<meta charset=UTF-8>
<title>Used Car Info</title>

<link rel="stylesheet" type="text/css" href="../Style/index.css"/>
<link rel="stylesheet" type="text/css" href="../Style/base.css"/>
<link rel="stylesheet" type="text/css" href="../Style/search_page.css"/>
<script>
	function go(la, miao){
		document.form.action.value = miao;
		document.form.uname.value = la;
		document.form.submit();
	}
</script>
</head>

<body>
	<div id="main_content">	
		<img class="picture_cell_top" src="../Style/top.jpg"/></br>
		
		<?php
		if (isset($_SESSION['username']) == false)
		{ 
			header("Location: ../home.php");
		} 
		else
		{
		?>
			<nav id="nav_bar">
			<a class="nav_links" id="home" href="admin.php">Home</a>
			<a class="nav_links" id="Logout" href="../logout.php">Logout</a>
			</nav>
		<?php
		}
		?>
		<div id="title_content">
			<br/>
			<div>
			<form action = 'user_manipulate.php' method = "POST">
				<input type = 'text' name = 'usern' placeholder = "Search Name Here" value = "<?php if(isset($_POST['usern'])) echo $_POST["usern"]; else echo ""?>">
				<input type = 'submit' name = 'search' value = 'Search'>
			</form>
			</div>
			<br/>
			<?php
				if(isset($_POST['search'])){
					require_once "pgpass.conf";
					$conn = pg_connect(HOST. " ". USER. " ". PASS. " ". DBNAME) or die("Cannot connect to ". pg_last_error());
					$query = "SELECT * FROM final_project.user_infor WHERE username ILIKE $1";
					pg_prepare($conn, "lala", $query);
					$result = pg_execute($conn, "lala", array("%".$_POST['usern']."%"));
					echo "<table border = '1'>\n"
						."<tr>\n<th>User Name</th>\n<th>registration date</th>\n<th>description</th>\n<th>email</th>\n<th>phone</th>\n<th>action</th></tr>\n";
					while($row = pg_fetch_array($result)){
						echo "<tr>";
						for($i = 0; $i < count($row) / 2 - 1; $i++)
							echo "\n<td>$row[$i]</td>";
						echo "\n<td><button type = 'button' onclick = 'go(\"". $row[0]. "\", \"delete\");'>DELETE</button></td>"
							."\n</tr>\n";
					}
					echo "</table>\n"
						."<form action = 'delete_user.php' method = 'POST' name = 'form'>\n"
						."<input type = 'hidden' name = 'action'>\n"
						."<input type = 'hidden' name = 'uname'>\n"
						."</form>\n";
				}
			?>
			<div>
			</div>
		</div>	
	</div>
</body>
</html>