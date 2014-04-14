<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--registeration.php-->

<?php
	function registeration($username,$password)
	{
		$conn = pg_connect("host=dbhost-pgsql.cs.missouri.edu user=cs3380f13grp13 dbname=cs3380f13grp13 password=pSxhC4we") or die("Could not connect:" . pg_last_error());
		mt_srand();
		$salt = mt_rand();
		$pwhash =sha1($salt.$password);
		
		$query = 'Insert into final_project.user_infor (username) values ($1)';
		pg_prepare($conn, "", $query);
		$result = pg_execute($conn, "", array($username));
		
		$query_2 = 'Insert into final_project.user_authentication (username, password_hash, salt) values ($1,$2,$3)';
		pg_prepare($conn, "", $query_2);
		$result = pg_execute($conn, "", array($username, $pwhash, $salt));
	}
?>