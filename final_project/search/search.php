<!DOCTYPE html>
<html>
<head>
<meta charset=UTF-8>
<title>Search Page</title>
<?php
		include("database.php");
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'.pg_last_error());  //connect the database
		$start=pg_prepare($conn,"make",'SELECT make AS m FROM final_project.car_infor GROUP BY make' ) or die('Could not prepare: ' . pg_last_error());
		$query1=pg_execute($conn,"make",array()) or die('Could not execute:'. pg_last_error());
		$start=pg_prepare($conn,"model",'SELECT model AS mo FROM final_project.car_infor  GROUP BY make' ) or die('Could not prepare: ' . pg_last_error());
		$query2=pg_execute($conn,"model",array()) or die('Could not execute:'. pg_last_error());
echo '
<SCRIPT LANGUAGE="JavaScript"> 
function Dsy(){
	this.Items = {}; 
} 
Dsy.prototype.add = function(id,iArray){
	this.Items[id] = iArray; 
} 
Dsy.prototype.Exists = function(id){ 
	if(typeof(this.Items[id]) == "undefined") return false; 
	return true; 
} 
function change(v){ 
	var str="0"; 
	for(i=0;i<v;i++){ str+=("_"+(document.getElementById(s[i]).selectedIndex-1));}; 
	var ss=document.getElementById(s[v]); 
	with(ss){ 
		length = 0; 
		options[0]=new Option(opt0[v],opt0[v]); 
		if(v && document.getElementById(s[v-1]).selectedIndex>0 || !v){ 
			if(dsy.Exists(str)){ 
				ar = dsy.Items[str]; 
				for(i=0;i<ar.length;i++)options[length]=new Option(ar[i],ar[i]); 
				if(v)options[1].selected = true; 
			} 
		} 
		if(++v<s.length){change(v);} 
	} 
}
var dsy = new Dsy();
dsy.add("0",[';
while($line1=pg_fetch_array($query1,null,PGSQL_ASSOC)){
	echo $line1['m'].",";
	}
echo '""])';
echo 'dsy.add("0_0",[';
while($line2=pg_fetch_array($query2,null,PGSQL_ASSOC)){
	echo $line2['mo'].",";
	}
echo '""])';
echo "</SCRIPT>";
	?>
<SCRIPT LANGUAGE = JavaScript> 
var s=["s1","s2"]; 
var opt0 = ["Make","Model"]; 
function setup() 
{ 
for(i=0;i<s.length-1;i++) 
document.getElementById(s[i]).onchange=new Function("change("+(i+1)+")"); 
change(0); 
} 
</SCRIPT>
</head>
<body>
<body onLoad="setup()"> 
<form name="frm"> 
<select id="s1"> 
<option>Make</option> 
</select> 
<select id="s2"> 
<option>Model</option> 
</select> 
<!--<table border=0>
<tr>
<td>
<form method="POST" action="">
<table border=0>
<tr>
<td>
<select name="make">
	<?php
		/*include("database.php");
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'.pg_last_error());  //connect the database
		$start=pg_prepare($conn,"make",'SELECT make AS m FROM final_project.car_infor GROUP BY make' ) or die('Could not prepare: ' . pg_last_error());
		$query=pg_execute($conn,"make",array()) or die('Could not execute:'. pg_last_error());
		while($line=pg_fetch_array($query,null,PGSQL_ASSOC)){
			echo "<option value='".$line['m']."'>".$line['m']."</option>";
		}*/
	?>
</select>
</td>

<td>
<select name="inventory_type">
	<option value="New" >New</option>
	<option value="Used" >Used</option>
</select>
</td>

<td>
<select name="inventory_type">
	<option value="5000" >Less than $5000</option>
	<option value="5000_15000" >$5000-$15000</option>
	<option value="15000_30000" >$15000-$30000</option>
	<option value="30000_45000" >$30000-$45000</option>
	<option value="45000" >Greater than $45000</option>
</select>
</td>

<td>
<select name="engine">
	<?php
		/*include("database.php");
		$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:'.pg_last_error());  //connect the database
		$start=pg_prepare($conn,"engine",'SELECT engine AS e FROM final_project.car_infor GROUP BY engine' ) or die('Could not prepare: ' . pg_last_error());
		$query=pg_execute($conn,"engine",array()) or die('Could not execute:'. pg_last_error());
		while($line=pg_fetch_array($query,null,PGSQL_ASSOC)){
			echo "<option value='".$line['e']."'>".$line['m']."</option>";
		}*/
	?>
</select>
</td>

<input type="submit" name="submit" value="Search" />
</form>
</tr>
</table>

<br />
<hr />
<br />

<strong>Select a query from the above list</strong>-->
</body>
</html>
