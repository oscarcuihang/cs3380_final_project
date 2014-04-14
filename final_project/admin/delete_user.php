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
		$authentication = "DELETE FROM final_project.user_authentication WHERE username = $1";
		$inform = "DELETE FROM final_project.user_infor WHERE username = $1";
		$log = "DELETE FROM final_project.log WHERE username = $1";
		pg_prepare($conn, "delete_auth", $authentication);
		pg_prepare($conn, "delete_infor", $inform);
		pg_prepare($conn, "delete_log", $log);
		pg_execute($conn, "delete_auth", array($_POST['uname']));
		pg_execute($conn, "delete_log", array($_POST['uname']));
		pg_execute($conn, "delete_infor", array($_POST['uname']));
		echo "Delete successfully!!";
		pg_close($conn);
		header("refresh: 0.3; url = user_manipulate.php");
	}
?>