<?php
	function match($a){
		switch($a){
			case 0 : return 'a';
			case 1 : return 'b';
			case 2 : return 'c';
			case 3 : return 'd';
			case 4 : return 'e';
			case 5 : return 'f';
			case 6 : return 'g';
			case 7 : return 'h';
			case 8 : return 'i';
			case 9 : return 'j';
			case 10 : return 'k';
			case 11 : return 'l';
			case 12 : return 'm';
			case 13 : return 'n';
			case 14 : return 'o';
			case 15 : return 'p';
			case 16 : return 'q';
			case 17 : return 'r';
			case 18 : return 's';
			case 19 : return 't';
			case 20 : return 'u';
			case 21 : return 'v';
			case 22 : return 'w';
			case 23 : return 'x';
			case 24 : return 'y';
			case 25 : return 'z';
			case 26 : return '0';
			case 27 : return '1';
			case 28 : return '2';
			case 29 : return '3';
			case 30 : return '4';
			case 31 : return '5';
			case 32 : return '6';
			case 33 : return '7';
			case 34 : return '8';
			case 35 : return '9';
			}
	}
	
	// generate a random alphanumeric sequence
	function randomSeq(){
		$length = rand(10, 20);
		$str = "";
		for($i = 0; $i < $length; $i++)
			$str .= match(rand(0,35));
		return $str;
	}
	
	
	function register($post){
		require_once "pgpass.conf";
		$conn = pg_connect(constant("HOST")." ".constant("DBNAME")." ".constant("USER")." ".constant("PASS")) 
			or die("Could not connect: ". pg_last_error());
		$query1 = "INSERT INTO final_project.user_infor (username, description, email, phone) VALUES($1, $2, $3, $4)";
		$query2 = "INSERT INTO final_project.user_authentication VALUES($1, $2, $3)";
		$query3 = "SELECT username FROM final_project.user_infor WHERE username = $1";
		$pass1 = htmlspecialchars($post['pass']);
		$pass2 = htmlspecialchars($post['repass']);
		$user = htmlspecialchars($post["user"]);
		if($pass1 == $pass2){
			pg_prepare($conn, "find", $query3);
			$result = pg_execute($conn, "find", array($user));
			if(pg_num_rows($result) > 0){
				pg_close($conn);
				return 0; 	// Account already exist
			}
			else {
				pg_prepare($conn, "query", $query1);
				pg_execute($conn, "query", array($user, $post["description"], $post['email'], $post['phone']));
				$salt = randomSeq(); //	create salt
				$store = sha1($pass1. $salt);	// hash the password and salt using sha1()
				pg_prepare($conn, "auth", $query2);
				pg_execute($conn, "auth", array($user, $store, $salt));
				echo "A New Account created Successfully!!!...Now redirecting..";
				$query = "INSERT INTO final_project.log (username, ip_address, action) VALUES($1, $2, $3)";
				pg_prepare($conn, "action", $query);
				$ip = $_SERVER["REMOTE_ADDR"];
				pg_execute($conn, "action", array($user, $ip, "Create New Account"));
				$_SESSION['log'] = TRUE;
				$_SESSION['user'] = $user;
				pg_close($conn);
				return 2; 	// Successfully create a new account;
			}
		}
		else {
			pg_close($conn);
			return 1;	// password not consistent
		}
	}
?>