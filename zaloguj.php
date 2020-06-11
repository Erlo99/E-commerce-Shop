<?php
	
	session_start();
	
	if((!isset($_POST['email'])) && (!$_POST['password'])){
		header('Location: login.php');
		exit();
	}
	
	require_once "connect.php";
	
	$connection = @new mysqli($host, $db_user, $db_password, $db_name, $port);
	
	if($connection->connect_errno!=0){
		echo "Error: ".$connection->connect_errno;
	}
	else {
		$login = $_POST['email'];
		$password = $_POST['password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
	}
	
	
	$sql = sprintf("SELECT * FROM users WHERE email='%s'",
			mysqli_real_escape_string($connection,$login));
	
	if($result = @$connection->query($sql)){
		$many_users = $result->num_rows;
			if($many_users>0){
				$row = $result->fetch_assoc();
				
				if(password_verify($password, $row['password'])){
				
				$_SESSION['logged'] = true;
				$_SESSION['id'] = $row['id_user'];
				$_SESSION['first'] =  $row['first'];
				unset($_SESSION['wrong']);
				$result->close();
				header('Location: index.php');
			} else {
				$_SESSION['wrong'] =  '<span style="color:red">Wrong email or password</span>';
				header('Location: login.php');
			}
		} else {
			$_SESSION['wrong'] =  '<span style="color:red">Wrong email or password</span>';
			header('Location: login.php');
		}
	}
	
	$connection->close();
	
?>