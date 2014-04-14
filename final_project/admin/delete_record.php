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
		require_once "pgpass.conf";
		$conn = pg_connect(HOST. " ". USER. " ". DBNAME. " ". PASS) or die("Cannot connect to ". pg_last_error());
		if($_POST['old_new'] == "old"){
			$query = "DELETE FROM final_project.used_car_infor WHERE car_id = $1";
			pg_prepare($conn, "old_deletion", $query);
			pg_execute($conn, "old_deletion", array($_POST['prkey']));
			echo "Successfully delete!!!";
			pg_close($conn);
			header("refresh: 0.4; url = record_manipulate.php");
		}
		else {
			$query = "DELETE FROM final_project.car_infor WHERE model = $1";
			pg_prepare($conn, "new_delete", $query);
			pg_execute($conn, "new_delete", array($_POST['prkey']));
			echo "Successfully delete!!!";
			pg_close($conn);
			header("refresh: 0.4; url = record_manipulate.php");
		}
?>