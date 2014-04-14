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

<script type="text/javascript">
function clickAction(form, ci, un, tbl, action)
{
  document.forms[form].elements['ci'].value = ci;
  document.forms[form].elements['tbl'].value = tbl;
  document.forms[form].elements['action'].value = action;
    document.forms[form].elements['un'].value = un;
  document.getElementById(form).submit();
}

function deletela(miao, ka, c){
	document.form.action.value = ka;
	document.form.prkey.value = miao;
	document.form.new_old.value = c;
	document.form.submit();
}
</script>

<link rel="stylesheet" type="text/css" href="../Style/index.css"/>
<link rel="stylesheet" type="text/css" href="../Style/base.css"/>
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<link rel="stylesheet" href="jq/lavalamp_test.css" type="text/css" media="screen">-->
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
		<h1 id="title">General Search</h1>
			<div>
			<form id="model" method="POST" action="record_manipulate.php">
				<select name="status">
					<option value="" >--select one--</option>
					<option value="new" >New</option>
					<option value="used" >Used</option>
				</select>
				
				<select name="make">
				<?php
					echo "<option value='' ></option>";
					require_once "pgpass.conf";
					$conn = pg_connect(HOST." ".DBNAME." ".USER." ".PASS) or die('Could not connect:'.pg_last_error());  //connect the database
					$start=pg_prepare($conn,"make",'SELECT make AS m FROM final_project.car_infor GROUP BY make' ) or die('Could not prepare: ' . pg_last_error());
					$query=pg_execute($conn,"make",array()) or die('Could not execute:'. pg_last_error());
					while($line=pg_fetch_array($query,null,PGSQL_ASSOC)){
						echo "<option value='".$line['m']."'>".$line['m']."</option>";
					}
				?>
				</select>
				
				<select name="price">
					<option value="" ></option>
					<option value="5000" >Less than $5000</option>
					<option value="10000" >Less than $10000</option>
					<option value="15000" >Less than $15000</option>
					<option value="20000" >Less than $20000</option>
					<option value="25000" >Less than $25000</option>
					<option value="30000" >Less than $30000</option>
					<option value="35000" >Less than $35000</option>
					<option value="40000" >Less than $40000</option>
					<option value="45000" >Less than $45000</option>
					<option value="50000" >Less than $50000</option>
					<option value="60000" >Less than $60000</option>
					<option value="70000" >Less than $70000</option>
					<option value="100000" >Less than $100000</option>
					<option value="200000" >Less than $200000</option>
					<option value="250000" >Less than $250000</option>
				</select>
				
				<select name="engine">
				<?php
					echo "<option value='' ></option>";
					require_once "pgpass.conf";
					//$conn = pg_connect(HOST." ".DBNAME." ".USER." ".PASS) or die('Could not connect:'.pg_last_error());  //connect the database
					$start=pg_prepare($conn,"engine",'SELECT engine AS e FROM final_project.car_infor GROUP BY engine' ) or die('Could not prepare: ' . pg_last_error());
					$query=pg_execute($conn,"engine",array()) or die('Could not execute:'. pg_last_error());
					while($line=pg_fetch_array($query,null,PGSQL_ASSOC)){
						echo "<option value='".$line['e']."'>".$line['e']."</option>";
					}
				?>
				</select>
				<input type="submit" name="car" value="Search">
			</form>
			</div>
			<?php
				if($_REQUEST['car']=='Search')
				{	
					//include("database.php");
					$status=$_REQUEST['status'];
					$make=$_REQUEST['make'];
					$price=$_REQUEST['price'];
					$engine=$_REQUEST['engine'];
					//$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'.pg_last_error());  //connect the database
					echo "<div>";
					echo "<form action = 'delete_record.php' method = 'POST' name = 'form'>\n"
						."<input type = 'hidden' name = 'action'>\n"
						."<input type = 'hidden' name = 'prkey'>\n"
						."<input type = 'hidden' name = 'new_old'>\n"
						."</form>\n";
					echo "<table border=1>\n";
					echo "<tr>";
					if($status=='new')
					{	
						//1.no make, no price, no engine
						if ($make == '' && $price =='' &&  $engine=='')
						{
							$query = "SELECT * FROM final_project.car_infor";
							pg_prepare($conn,"search",$query ) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array()) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							for($j=0;$j<$i;$j++) 
							{
								echo "<td><strong><center>";
								$field_name = pg_field_name($result,$j);
								echo(htmlspecialchars($field_name));
								echo "</center></strong></td>\n";
							}
							while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								foreach ($line as $haha) 
								{
									echo "\t\t<td>$haha</td>\n";
								}
								$la = $line[0];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"old\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						
						// 2. no make, no price, have engine
						if (($make == '') && ($price =='') &&  ($engine !=''))
						{
							$query = "SELECT * FROM final_project.car_infor WHERE engine = $1";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($engine)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							for($j=0;$j<$i;$j++) 
							{
								echo "<td><strong><center>";
								$field_name = pg_field_name($result,$j);
								echo(htmlspecialchars($field_name));
								echo "</center></strong></td>\n";
							}
							while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								foreach ($line as $haha) 
								{
									echo "\t\t<td>$haha</td>\n";
								}
								$la = $line[0];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"old\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}	
						
						//3.no make, have price, no engine
						if (($make == '') && ($price !='') &&  ($engine ==''))
						{
							$query = "SELECT * FROM final_project.car_infor WHERE base_price < $1";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($price)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							for($j=0;$j<$i;$j++) 
							{
								echo "<td><strong><center>";
								$field_name = pg_field_name($result,$j);
								echo(htmlspecialchars($field_name));
								echo "</center></strong></td>\n";
							}
							while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								foreach ($line as $haha) 
								{
									echo "\t\t<td>$haha</td>\n";
								}
								$la = $line[0];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"old\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						
						//4.no make, have price, have engine
						if (($make == '') && ($price !='') &&  ($engine !=''))
						{
							$query = "SELECT * FROM final_project.car_infor WHERE base_price < $1 and engine = $2";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($price, $engine)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							for($j=0;$j<$i;$j++) 
							{
								echo "<td><strong><center>";
								$field_name = pg_field_name($result,$j);
								echo(htmlspecialchars($field_name));
								echo "</center></strong></td>\n";
							}
							while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								foreach ($line as $haha) 
								{
									echo "\t\t<td>$haha</td>\n";
								}
								$la = $line[0];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"old\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						
						//5.have make, no price, no engine
						if (($make != '') && ($price =='') &&  ($engine ==''))
						{
							$query = "SELECT * FROM final_project.car_infor WHERE make = $1";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($make)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							for($j=0;$j<$i;$j++) 
							{
								echo "<td><strong><center>";
								$field_name = pg_field_name($result,$j);
								echo(htmlspecialchars($field_name));
								echo "</center></strong></td>\n";
							}
							while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								foreach ($line as $haha) 
								{
									echo "\t\t<td>$haha</td>\n";
								}
								$la = $line[0];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"old\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						
						//6.have make, no price, have engine
						if (($make != '') && ($price =='') &&  ($engine !=''))
						{
							$query = "SELECT * FROM final_project.car_infor WHERE make = $1 and engine = $2";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($make, $engine)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							for($j=0;$j<$i;$j++) 
							{
								echo "<td><strong><center>";
								$field_name = pg_field_name($result,$j);
								echo(htmlspecialchars($field_name));
								echo "</center></strong></td>\n";
							}
							while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								foreach ($line as $haha) 
								{
									echo "\t\t<td>$haha</td>\n";
								}
								$la = $line[0];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"old\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						
						//7.have make, have price, no engine
						if (($make != '') && ($price !='') &&  ($engine ==''))
						{
							$query = "SELECT * FROM final_project.car_infor WHERE make = $1 and base_price<$2";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($make, $price)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							for($j=0;$j<$i;$j++) 
							{
								echo "<td><strong><center>";
								$field_name = pg_field_name($result,$j);
								echo(htmlspecialchars($field_name));
								echo "</center></strong></td>\n";
							}
							while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								foreach ($line as $haha) 
								{
									echo "\t\t<td>$haha</td>\n";
								}
								$la = $line[0];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"old\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						
						//8.have make, have price, have engine
						if (($make != '') && ($price !='') &&  ($engine !=''))
						{
							$query = "SELECT * FROM final_project.car_infor WHERE make=$1 AND base_price<$2 AND engine=$3";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($make,$price,$engine)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							for($j=0;$j<$i;$j++) 
							{
								echo "<td><strong><center>";
								$field_name = pg_field_name($result,$j);
								echo(htmlspecialchars($field_name));
								echo "</center></strong></td>\n";
							}
							while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								foreach ($line as $haha) 
								{
									echo "\t\t<td>$haha</td>\n";
								}
								$la = $line[0];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"old\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
					}
					
					if($status=='used')
					{	
						echo "<form action='../used_car_info_exec.php' id='action_form' method='POST'>";
						echo "<input type='hidden' name='ci'>";
						echo "<input type='hidden' name='tbl'>";
						echo "<input type='hidden' name='action'>";
						echo "<input type='hidden' name='un'>";
						echo "<td><b>Info</b></td>";
						//1.no make, no price, no engine
						if ($make == '' && $price =='' &&  $engine=='')
						{
							$query = "SELECT * FROM final_project.used_car_infor";
							pg_prepare($conn,"search",$query ) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array()) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							echo "<td><b>Belong</b></td>";
							echo "<td><b>make</b></td>";
							echo "<td><b>model</b></td>";
							echo "<td><b>price</b></td>";
							echo "<td><b>city</b></td>";
							echo "<td><b>hway</b></td>";
							echo "<td><b>doors</b></td>";
							echo "<td><b>engine</b></td>";
							echo "<td><b>car_year</b></td>";
							while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) 
							{	
								$carid	= $line['car_id'];
								$uname = $line['username'];
								echo "\t<tr>\n";
								echo "<td><input type=\"button\" name=\"action1\" value=\"YES\" onclick=\"clickAction('action_form','".$carid."','".$uname."','used_car_infor','info');\" /></td>";
								echo "<td>".$line['username']."</td>";
								echo "<td>".$line['make']."</td>";
								echo "<td>".$line['model']."</td>";
								echo "<td>".$line['price']."</td>";
								echo "<td>".$line['city_mpg']."</td>";
								echo "<td>".$line['hway_mpg']."</td>";
								echo "<td>".$line['doors']."</td>";
								echo "<td>".$line['engine']."</td>";
								echo "<td>".$line['car_year']."</td>";
								$la = $line['model'];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"new\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						
						// 2. no make, no price, have engine
						if (($make == '') && ($price =='') &&  ($engine !=''))
						{
							$query = "SELECT * FROM final_project.used_car_infor WHERE engine = $1";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($engine)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							echo "<td><b>Belong</b></td>";
							echo "<td><b>make</b></td>";
							echo "<td><b>model</b></td>";
							echo "<td><b>price</b></td>";
							echo "<td><b>city_mpg</b></td>";
							echo "<td><b>hway_mpg</b></td>";
							echo "<td><b>doors</b></td>";
							echo "<td><b>engine</b></td>";
							echo "<td><b>car_year</b></td>";
							while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								$carid	= $line['car_id'];
								$uname = $line['username'];
								echo "\t<tr>\n";
								echo "<td><input type=\"button\" name=\"action1\" value=\"YES\" onclick=\"clickAction('action_form','".$carid."','".$uname."','used_car_infor','info');\" /></td>";
								echo "<td>".$line['username']."</td>";
								echo "<td>".$line['make']."</td>";
								echo "<td>".$line['model']."</td>";
								echo "<td>".$line['price']."</td>";
								echo "<td>".$line['city_mpg']."</td>";
								echo "<td>".$line['hway_mpg']."</td>";
								echo "<td>".$line['doors']."</td>";
								echo "<td>".$line['engine']."</td>";
								echo "<td>".$line['car_year']."</td>";
								$la = $line['model'];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"new\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}	
						
						//3.no make, have price, no engine
						if (($make == '') && ($price !='') &&  ($engine ==''))
						{
							$query = "SELECT * FROM final_project.used_car_infor WHERE price < $1";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($price)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							echo "<td><b>Belong</b></td>";
							echo "<td><b>make</b></td>";
							echo "<td><b>model</b></td>";
							echo "<td><b>price</b></td>";
							echo "<td><b>city_mpg</b></td>";
							echo "<td><b>hway_mpg</b></td>";
							echo "<td><b>doors</b></td>";
							echo "<td><b>engine</b></td>";
							echo "<td><b>car_year</b></td>";
							while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								$carid	= $line['car_id'];
								$uname = $line['username'];
								echo "\t<tr>\n";
								echo "<td><input type=\"button\" name=\"action1\" value=\"YES\" onclick=\"clickAction('action_form','".$carid."','".$uname."','used_car_infor','info');\" /></td>";
								echo "<td>".$line['username']."</td>";
								echo "<td>".$line['make']."</td>";
								echo "<td>".$line['model']."</td>";
								echo "<td>".$line['price']."</td>";
								echo "<td>".$line['city_mpg']."</td>";
								echo "<td>".$line['hway_mpg']."</td>";
								echo "<td>".$line['doors']."</td>";
								echo "<td>".$line['engine']."</td>";
								echo "<td>".$line['car_year']."</td>";
								$la = $line['model'];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"new\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						
						//4.no make, have price, have engine
						if (($make == '') && ($price !='') &&  ($engine !=''))
						{
							$query = "SELECT * FROM final_project.used_car_infor WHERE price < $1 and engine = $2";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($price, $engine)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							echo "<td><b>Belong</b></td>";
							echo "<td><b>make</b></td>";
							echo "<td><b>model</b></td>";
							echo "<td><b>price</b></td>";
							echo "<td><b>city_mpg</b></td>";
							echo "<td><b>hway_mpg</b></td>";
							echo "<td><b>doors</b></td>";
							echo "<td><b>engine</b></td>";
							echo "<td><b>car_year</b></td>";
							while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								$carid	= $line['car_id'];
								$uname = $line['username'];
								echo "\t<tr>\n";
								echo "<td><input type=\"button\" name=\"action1\" value=\"YES\" onclick=\"clickAction('action_form','".$carid."','".$uname."','used_car_infor','info');\" /></td>";
								echo "<td>".$line['username']."</td>";
								echo "<td>".$line['make']."</td>";
								echo "<td>".$line['model']."</td>";
								echo "<td>".$line['price']."</td>";
								echo "<td>".$line['city_mpg']."</td>";
								echo "<td>".$line['hway_mpg']."</td>";
								echo "<td>".$line['doors']."</td>";
								echo "<td>".$line['engine']."</td>";
								echo "<td>".$line['car_year']."</td>";
								$la = $line['model'];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"new\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						
						//5.have make, no price, no engine
						if (($make != '') && ($price =='') &&  ($engine ==''))
						{
							$query = "SELECT * FROM final_project.used_car_infor WHERE make = $1";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($make)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							echo "<td><b>Belong</b></td>";
							echo "<td><b>make</b></td>";
							echo "<td><b>model</b></td>";
							echo "<td><b>price</b></td>";
							echo "<td><b>city_mpg</b></td>";
							echo "<td><b>hway_mpg</b></td>";
							echo "<td><b>doors</b></td>";
							echo "<td><b>engine</b></td>";
							echo "<td><b>car_year</b></td>";
							while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								$carid	= $line['car_id'];
								$uname = $line['username'];
								echo "\t<tr>\n";
								echo "<td><input type=\"button\" name=\"action1\" value=\"YES\" onclick=\"clickAction('action_form','".$carid."','".$uname."','used_car_infor','info');\" /></td>";
								echo "<td>".$line['username']."</td>";
								echo "<td>".$line['make']."</td>";
								echo "<td>".$line['model']."</td>";
								echo "<td>".$line['price']."</td>";
								echo "<td>".$line['city_mpg']."</td>";
								echo "<td>".$line['hway_mpg']."</td>";
								echo "<td>".$line['doors']."</td>";
								echo "<td>".$line['engine']."</td>";
								echo "<td>".$line['car_year']."</td>";
								$la = $line['model'];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"new\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						
						//6.have make, no price, have engine
						if (($make != '') && ($price =='') &&  ($engine !=''))
						{
							$query = "SELECT * FROM final_project.used_car_infor WHERE make = $1 and engine = $2";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($make, $engine)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							echo "<td><b>Belong</b></td>";
							echo "<td><b>make</b></td>";
							echo "<td><b>model</b></td>";
							echo "<td><b>price</b></td>";
							echo "<td><b>city_mpg</b></td>";
							echo "<td><b>hway_mpg</b></td>";
							echo "<td><b>doors</b></td>";
							echo "<td><b>engine</b></td>";
							echo "<td><b>car_year</b></td>";
							while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								$carid	= $line['car_id'];
								$uname = $line['username'];
								echo "\t<tr>\n";
								echo "<td><input type=\"button\" name=\"action1\" value=\"YES\" onclick=\"clickAction('action_form','".$carid."','".$uname."','used_car_infor','info');\" /></td>";
								echo "<td>".$line['username']."</td>";
								echo "<td>".$line['make']."</td>";
								echo "<td>".$line['model']."</td>";
								echo "<td>".$line['price']."</td>";
								echo "<td>".$line['city_mpg']."</td>";
								echo "<td>".$line['hway_mpg']."</td>";
								echo "<td>".$line['doors']."</td>";
								echo "<td>".$line['engine']."</td>";
								echo "<td>".$line['car_year']."</td>";
								$la = $line['model'];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"new\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						
						//7.have make, have price, no engine
						if (($make != '') && ($price !='') &&  ($engine ==''))
						{
							$query = "SELECT * FROM final_project.used_car_infor WHERE make = $1 and price<$2";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($make, $price)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							echo "<td><b>Belong</b></td>";
							echo "<td><b>make</b></td>";
							echo "<td><b>model</b></td>";
							echo "<td><b>price</b></td>";
							echo "<td><b>city_mpg</b></td>";
							echo "<td><b>hway_mpg</b></td>";
							echo "<td><b>doors</b></td>";
							echo "<td><b>engine</b></td>";
							echo "<td><b>car_year</b></td>";
							while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								$carid	= $line['car_id'];
								$uname = $line['username'];
								echo "\t<tr>\n";
								echo "<td><input type=\"button\" name=\"action1\" value=\"YES\" onclick=\"clickAction('action_form','".$carid."','".$uname."','used_car_infor','info');\" /></td>";
								echo "<td>".$line['username']."</td>";
								echo "<td>".$line['make']."</td>";
								echo "<td>".$line['model']."</td>";
								echo "<td>".$line['price']."</td>";
								echo "<td>".$line['city_mpg']."</td>";
								echo "<td>".$line['hway_mpg']."</td>";
								echo "<td>".$line['doors']."</td>";
								echo "<td>".$line['engine']."</td>";
								echo "<td>".$line['car_year']."</td>";
								$la = $line['model'];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"new\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						
						//8.have make, have price, have engine
						if (($make != '') && ($price !='') &&  ($engine !=''))
						{
							$query = "SELECT * FROM final_project.used_car_infor WHERE make=$1 AND price<$2 AND engine=$3";
							pg_prepare($conn,"search",$query) or die('Could not prepare: ' . pg_last_error());
							$result=pg_execute($conn,"search",array($make,$price,$engine)) or die('Could not execute:'. pg_last_error());
							$i = pg_num_fields($result);
							
							echo "<td><b>Belong</b></td>";
							echo "<td><b>make</b></td>";
							echo "<td><b>model</b></td>";
							echo "<td><b>price</b></td>";
							echo "<td><b>city_mpg</b></td>";
							echo "<td><b>hway_mpg</b></td>";
							echo "<td><b>doors</b></td>";
							echo "<td><b>engine</b></td>";
							echo "<td><b>car_year</b></td>";
							while ($line = pg_fetch_array($result, NULL, PGSQL_ASSOC)) 
							{	
								echo "\t<tr>\n";
								$carid	= $line['car_id'];
								$uname = $line['username'];
								echo "\t<tr>\n";
								echo "<td><input type=\"button\" name=\"action1\" value=\"YES\" onclick=\"clickAction('action_form','".$carid."','".$uname."','used_car_infor','info');\" /></td>";
								echo "<td>".$line['username']."</td>";
								echo "<td>".$line['make']."</td>";
								echo "<td>".$line['model']."</td>";
								echo "<td>".$line['price']."</td>";
								echo "<td>".$line['city_mpg']."</td>";
								echo "<td>".$line['hway_mpg']."</td>";
								echo "<td>".$line['doors']."</td>";
								echo "<td>".$line['engine']."</td>";
								echo "<td>".$line['car_year']."</td>";
								$la = $line['model'];
								echo "<td><button type = 'button' onclick = 'deletela(\"$la\", \"delete\", \"new\");'>X</button></td>";
								echo "\t</tr>\n";
							}
						}
						echo "</form>";
				}
				echo "\t</tr>\n";
				echo "</table></div>";
			}
			?>
		</div>	
	</div>
</body>
</html>