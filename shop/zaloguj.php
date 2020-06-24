<?php
	
	session_start();
	
	if((!isset($_POST['email'])) && (!$_POST['password'])){
		header('Location: login.php');
		exit();
	}
	
	require_once "connect.php";
	
	try{
		$connection = @new mysqli($host, $db_user, $db_password, $db_name, $port);
	if($connection->connect_errno!=0){
		throw new Exception(mysqli_connect_errno());
	}
	else {
		$login = $_POST['email'];
		$password = $_POST['password'];
		
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
	//search in db
		$sql = sprintf("SELECT * FROM users WHERE email='%s'",
				mysqli_real_escape_string($connection,$login));
		
		$result = @$connection->query($sql);
		
		if($result){
			$many_users = $result->num_rows;
				if($many_users>0){
					$row = $result->fetch_assoc();
					
					if(password_verify($password, $row['password'])){
					
					$_SESSION['logged'] = true;
					$_SESSION['id'] = $row['id_user'];
					$_SESSION['first'] =  $row['first'];
					unset($_SESSION['wrong']);
					$_SESSION['loggedEmail'] = $row['email'];
					
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
		}
	} catch (Exception $e){
		echo 'Server error';
		echo $e;
	}
	
	
?>