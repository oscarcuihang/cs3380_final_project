<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<form action = "A.php" method = 'POST'>
		<input type = 'text' name = 'pass'>
		<input type = 'text' name = 'salt'>
		<input type = 'submit' name = 'submit'>
	</form>
	<?php
		if(isset($_POST['submit'])){
			echo sha1($_POST['salt'].$_POST['pass']);
		}
	?>
</body>
</html>