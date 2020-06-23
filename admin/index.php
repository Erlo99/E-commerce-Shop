<?php
	session_start();
	
	if((!isset($_SESSION['loggedAdmin'])) && !($_SESSION['loggedAdmin']==true)){
		header('Location: loginAdmin.php');
		exit();
	}
	
	
	
	
?>

<!DOCTYPE html>
<html lang="en" >
<head>
	<title>Panel</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
<div class="jumbotron text-center">
	<a href="../logout.php" class="">Logout</a>

</div>
	<div class="container">
	
		<div class="row text-center">
			<div class="col-<?php   if($_SESSION['role'] == 'admin') 
										echo '3';
									else echo '6';
				?>">
			<a href="orders.php">Orders</a>
			</div>
			<div class="col-<?php   if($_SESSION['role'] == 'admin') 
										echo '3';
									else echo '6';
				?>">
			<a href="products.php">Products</a>
			</div>
			<?php   if($_SESSION['role'] == 'admin') 
			echo '
			<div class="col-3">
			<a href="users.php">Users</a>
			</div>
			<div class="col-3">
			<a href="workers.php">workers</a>
			</div>
			';
			?>
			
		</div>
	</div>
	
</body>
</html>