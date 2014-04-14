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
	//require_once('log.php');
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

<script type="text/javascript">
function clickAction(form, ci, tbl, action)
{
  document.forms[form].elements['ci'].value = ci;
  document.forms[form].elements['tbl'].value = tbl;
  document.forms[form].elements['action'].value = action;
  document.getElementById(form).submit();
}
</script>

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
			<p id="text_1">
				Hello <?php echo $_SESSION['username']?>
			</p>
			<P id="text"> 
				Or insert a new car by clicking this <a href="exec.php?action=insert">link</a>
			</p>
			<?php
				$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());
				$query = 'SELECT * FROM final_project.used_car_infor WHERE username = $1';
				pg_prepare($conn, "car", $query);
				$result = pg_execute($conn, "car", array($_SESSION['username']));
				$i = pg_num_fields($result);
				echo "<form action='exec.php' id='action_form' method='POST'>";
				echo "<input type='hidden' name='ci'>";
				echo "<input type='hidden' name='tbl'>";
				echo "<input type='hidden' name='action'>";
			?>
				<table border = 1>
			<?php
				echo "<tr>";
				echo "<td><strong><center>"."Action"."</center></strong></td>";
				for($j=0;$j<$i;$j++) 
				{
					echo "<td><strong><center>";
					$field_name = pg_field_name($result,$j);
					echo(htmlspecialchars($field_name));
					echo "</center></strong></td>\n";
				}
				
				while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
				{
					$carid = $line['car_id'];
					echo "\t<tr>\n";
					echo "\t<td>\n";
					echo "<input type=\"button\" name=\"action1\" value=\"Edit\" onclick=\"clickAction('action_form','".$carid."','used_car_infor','edit');\" />";
					echo "<input type=\"button\" name=\"action1\" value=\"Remove\" onclick=\"clickAction('action_form','".$carid."','used_car_infor','remove');\" />";
					echo "\t</td>\n";
					foreach ($line as $haha) 
					{
						echo "\t\t<td>$haha</td>\n";
					}
					echo "\t</tr>\n";
				}
				
				echo "</tr>";
				echo "</form>";
			?>
				</table>
			<?php
			?>
		<div>
		</div>
	</div>
</body>
</html>
<?php
}
?>
