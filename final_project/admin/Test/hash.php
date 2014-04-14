<!DOCTYPE html>
<html>
<head>
<title>hash test</title>
</head>
<body>
<form action = 'hash.php' method = 'post'>
	<label for = 'pass'>Password:</label>
	<input id = 'pass' type = 'text' name = 'password'>
	<label for = 'salt'>Salt : </label>
	<input id = 'salt' type = 'text' name = 'salt'>
	<input type = 'submit' name = 'submit'>
</form>
<?php
	if(isset($_POST['submit'])){
		echo "<hr>".sha1($_POST['salt'].$_POST['password']);
	}
?>
</body>
</html>