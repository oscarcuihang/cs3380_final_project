<?php
	include_once "../pgpass.conf";
	$conn = pg_connect(constant("HOST")." ".constant("DBNAME")." ".constant("USER")." ".constant("PASS"))
		or die("Cannot connect to the database due to ".pg_last_error());
	pg_prepare($conn, "log", "SELECT * FROM final_project.user_infor WHERE username = $1 UNION SELECT * FROM final_project.adm_infor WHERE username = $1");
	$result = pg_execute($conn, "log", array("miao"));
	echo pg_num_rows($result);
	
	pg_close($conn);
?>
