<?php
	
	session_start();
	
	if((!isset($_POST['login'])) && (!$_POST['password'])){
		header('Location: loginAdmin.php');
		exit();
	}
	
	define("SITE_ROOT", "../");
	require_once (SITE_ROOT."/connect.php");
	
	
	try{
		$connection = @new mysqli($host, $db_user, $db_password, $db_name, $port);
		echo "ok2";
	if($connection->connect_errno!=0){
		throw new Exception(mysqli_connect_errno());
		echo "ok3";
	}
	else {
		$login = $_POST['login'];
		$password = $_POST['password'];
		echo "ok4<br>";
		echo $login.'<br>';
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		echo $login;
	//search in db
		$sql = sprintf("SELECT * FROM workers WHERE login='%s'",
				mysqli_real_escape_string($connection,$login));
		
		$result = @$connection->query($sql);
		
		if($result){
			echo "ok5";
			$many_users = $result->num_rows;
			echo $many_users;
				if($many_users>0){
					echo "ok6";
					$row = $result->fetch_assoc();
					
					if(password_verify($password, $row['password'])){
					
					$_SESSION['loggedAdmin'] = true;
					$_SESSION['id'] = $row['id_worker'];
					$_SESSION['first'] =  $row['first'];
					$_SESSION['role'] = $row['role'];
					unset($_SESSION['wrong']);
					
					
					$result->close();
					
					 header('Location: index.php');
					
				} else
					header('Location: loginAdmin.php');	
			}else
					header('Location: loginAdmin.php');	
		} 
			
			$connection->close();
		}
	} catch (Exception $e){
		echo 'Server error';
		echo $e;
	}
	
	
?>