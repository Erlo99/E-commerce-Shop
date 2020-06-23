<?php
	
	session_start();
	
	if((!isset($_POST['login'])) && (!$_POST['password'])){
		header('Location: loginAdmin.php');
		exit();
	}
	
	require_once "connect.php";
	
	try{
		$connection = @new mysqli($host, $db_user, $db_password, $db_name, $port);
	if($connection->connect_errno!=0){
		throw new Exception(mysqli_connect_errno());
	}
	else {
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
	//search in db
		$sql = sprintf("SELECT * FROM workers WHERE login='%s'",
				mysqli_real_escape_string($connection,$login));
		
		$result = @$connection->query($sql);
		
		if($result){
			$many_users = $result->num_rows;
				if($many_users>0){
					$row = $result->fetch_assoc();
					
					if(password_verify($password, $row['password'])){
					
					$_SESSION['loggedAdmin'] = true;
					$_SESSION['id'] = $row['id_worker'];
					$_SESSION['first'] =  $row['first'];
					$_SESSION['role'] = $row['role'];
					unset($_SESSION['wrong']);
					
					
					$result->close();
					
					 header('Location: panelAdmin.php');
					
				} 
			}
		}
			
			$connection->close();
		}
	} catch (Exception $e){
		echo 'Server error';
		echo $e;
	}
	
	
?>