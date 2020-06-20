<?php
	session_start();
	
	$_SESSION["cart"] = array();
	if(isset($_POST['add_cart'])){

		 echo $_GET['id'];

	}
	require_once "connect.php";
	
	try{
		$connection = @new mysqli($host, $db_user, $db_password, $db_name, $port);
	if($connection->connect_errno!=0){
		throw new Exception(mysqli_connect_errno());
	}
	else {
		$id = $_GET['id'];
		

	//search in db
		$sql = sprintf("SELECT * FROM products WHERE id_product='%s'", $id);
		
		$result = @$connection->query($sql);
		
		if($result){
			$product = $result->num_rows;
				if($product>0){
					$row = $result->fetch_assoc();

					echo $row['id_product'];
					echo $row['Price'];
					echo $row['Stock'];
					echo $_GET['quantity'];
					$result->close();
					//header('Location: ' . $_SERVER['HTTP_REFERER']);
				
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