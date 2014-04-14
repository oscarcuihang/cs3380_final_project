<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--log.php-->

<?php
	function log_status($username, $ip, $action)
	{
		$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());
		$query = 'INSERT INTO final_project.log (username, ip_address, action) values ($1, $2, $3)';
		pg_prepare($conn, "", $query);
		$result = pg_execute($conn, "", array($username, $ip, $action));
	}
?>