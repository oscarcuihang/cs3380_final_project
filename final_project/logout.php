<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--logout.php-->

<?php
	if (($_SERVER['HTTPS']) != 'on')
	{
		$abc = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("location: $abc");
	}
	session_start();
	require_once('log.php');
	log_status($_SESSION['username'],$_SERVER['REMOTE_ADDR'],'log out');
	unset($_SESSION['username']);
	$_SESSION['log'] = "off";
	session_destroy();
	//send user back to index.php
	header("location: home.php");

?>