<!--cs3380 Final Project Group13-->
<!--Car Dealer-->
<!--upload.php-->

<?php
	if (($_SERVER['HTTPS']) != 'on')
	{
		$abc = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		header("location: $abc");
	}
	session_cache_limiter('private, must-revalidate');
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Car Dealer</title>
<style></style>
<link rel="stylesheet" type="text/css" href="Style/index.css"/>
<link rel="stylesheet" type="text/css" href="Style/base.css"/>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
<div id="main_content">	
		<img class="picture_cell_top" src="Style/top.jpg"/></br>
		<div>
		
		</div>
</div>
</body>
</html>