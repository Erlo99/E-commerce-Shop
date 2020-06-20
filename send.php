<?php
session_start();

	
	require_once('connect.php');
	if((!isset($_SESSION['logged'])) && !($_SESSION['logged']==true)){
		header('Location: checkout.php');
		$_SESSION('you have to login to order');
		exit();
	}
	
	//if(isset($_POST['submit'])){
	//   $_SESSION['incrementOrder'] += 1;
	//}
	
	//check phone
		if(strlen($_POST['phone'])!=9){
			
			$_SESSION['e_number'] = '<span style="color:red"><br>Number must contain 9 digits</span>';
			unset($_POST['phone']);
			
		} elseif (!preg_match('/^[1-9][0-9]*$/', $_POST['phone'])){
			
			$_SESSION['e_number'] = '<span style="color:red"><br>Only digits</span>';
			unset($_POST['phone']);
		}
		
		//check email
		
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $email != $_POST['email']){
			
			$_SESSION['e_email'] = '<span style="color:red"><br>Wrong email address</span>';
			unset($_POST['email']);
		}
		
		//card validation
		
		
		//card
		if(strlen($_POST['card'])!=16){
			
			$_SESSION['e_card'] = '<span style="color:red"><br>Number must contain 16 digits</span>';
			unset($_POST['card']);
			
		} elseif (!preg_match('/^[1-9][0-9]*$/', $_POST['card'])){
			
			$_SESSION['e_card'] = '<span style="color:red"><br>Only digits</span>';
			unset($_POST['card']);
		}
		//cvv
		if(strlen($_POST['cvv'])!=3){
			
			$_SESSION['e_cvv'] = '<span style="color:red"><br>Number must contain 3 digits</span>';
			unset($_POST['cvv']);
			
		} elseif (!preg_match('/^[1-9][0-9]*$/', $_POST['cvv'])){
			
			$_SESSION['e_cvv'] = '<span style="color:red"><br>Only digits</span>';
			unset($_POST['cvv']);
		}
		//month
		if(strlen($_POST['month'])!=2 ){
			
			$_SESSION['e_month'] = '<span style="color:red"><br>Number must contain 2 digits</span>';
			unset($_POST['month']);
			
		} elseif (!preg_match('/^[1-9][0-9]*$/', $_POST['month'])){
			
			$_SESSION['e_month'] = '<span style="color:red"><br>Only digits</span>';
			unset($_POST['month']);
		}
		//year
		if(strlen($_POST['year'])!=2 || substr($_POST['year'], 0,1) == '1' || substr($_POST['year'], 0,1) == '0' ){
			
			$_SESSION['e_year'] = '<span style="color:red"><br>Number must contain 2 digits</span>';
			unset($_POST['year']);
			
		} elseif (!preg_match('/^[1-9][0-9]*$/', $_POST['year'])){
			
			$_SESSION['e_year'] = '<span style="color:red"><br>Only digits</span>';
			unset($_POST['year']);
		}
		
		
	
	$i=0;
	$j=0;
	$_SESSION['shipping'] = array(
							'id' => $_POST['id'],
							'first' =>$_POST['first'],
							'last' => $_POST['last'],
							'email' => $_POST['email'],
							'country' => $_POST['country'],
							'adress1' =>$_POST['adress1'],
							'adress2' => $_POST['adress2'],
							'city' => $_POST['city'],
							'district' => $_POST['district'],
							'zip' => $_POST['zip'],
							'phone' => $_POST['phone'],
							'card' => $_POST['card'],
							'cvv' => $_POST['cvv'],
							'month' => $_POST['month'],
							'year' => $_POST['year'],
							'company' => $_POST['company'],
							);
	//shipping validation
		foreach($_POST as $key => $value){
			$i++;
			
			
			
			if($value == '') {
				$j++;
				
				
				$_SESSION['bad'] = '<span style="color: red">Fill field correctly</span>';
			}
			if($i == 10) break;
		}
		if($_POST['adress2'] == '') $j--;
		if($_POST['company'] == '') $j--;
		if($_POST['id'] == '') $j--;
		
		if($j == 0) {
			unset($_SESSION['bad']);
			     
			try{
			$connection = @new mysqli($host, $db_user, $db_password, $db_name, $port);
			if($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			} else {
							$query ="SELECT id_order FROM orders ORDER BY id_order DESC LIMIT 1";
							$result = $connection->query($query);
							$idOrder = $result->fetch_assoc();
							$idOrder['id_order']++;
				foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
							
							$query = "INSERT INTO orders (id_order, id_product, id_user, quantity, send)
									VALUES ('".$idOrder['id_order']."','".$values['id']."', '".$_POST['id']."', '".$values['quantity']."', '0')";
							mysqli_query($connection, $query);
						}
				
				$connection->close();
			}
			} catch(Exception $e){
				echo 'Server error!';
				echo $e;
			}	
			//header('Location: confirmation.php');
			
			//header('Location: checkout.php');
			}else header('Location: checkout.php');
			
		
		

//echo $_SESSION['logged'];
//echo $_POST['first'];

?>