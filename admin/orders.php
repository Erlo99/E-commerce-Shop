<?php
	session_start();
	
	
	if((!isset($_SESSION['loggedAdmin'])) && !($_SESSION['loggedAdmin']==true)){
		header('Location: loginAdmin.php');
		exit();
	}
	
	define("SITE_ROOT", "../");
	require_once (SITE_ROOT."/connect.php");
	
	
	 
	try{
		$connection = @new mysqli($host, $db_user, $db_password, $db_name, $port);
	if($connection->connect_errno!=0){
		throw new Exception(mysqli_connect_errno());
	}
	else {
		
		if(isset($_GET['id'])){
		 $sql = sprintf("UPDATE orders 
					SET send = 1
					WHERE id_order = ".$_GET['id']."");
		@$connection->query($sql);
		}

	//search in db
		$sql = sprintf("SELECT orders.id_order AS id_order, users.first AS first,
		users.last AS last, products.title AS title, orders.quantity AS quantity,
		orders.send AS status, users.id_user AS id_user FROM orders INNER JOIN
		users ON orders.id_user = users.id_user INNER JOIN 
		products ON orders.id_product = products.id_product ORDER BY id_order DESC");
		
		$result = @$connection->query($sql);
		
		if($result){
			

			$product = $result->num_rows;
			
				if($product>0){
					
						for($i=0;$i<$product;$i++){
						$row = $result->fetch_assoc();
						
						$items = array(
							"id_user" => $row['id_user'],
							"id_order" => $row['id_order'], 
							"first" => $row['first'], 
							"last" => $row['last'],
							"title" => $row['title'],
							"quantity" => $row['quantity'],
							"status" => $row['status']);
							
						$_SESSION["orders"][$i] = $items;
						}		
						
						

						
						}
						
				
		
					$result->close();
					
				
			} 
		}
		
			$connection->close();
		
	} catch (Exception $e){
		echo 'Server error';
		echo $e;
	}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
	<title>Orders</title>
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
<body >
	<div class="jumbotron text-center">
		<h1>ORDERS</h1>
	</div>
	<div class="container">
	
		<div class="row text-center">
			<div class="col-6">
			<a href="index.php">Go Back</a>
			</div>
			<div class="col-6">
			<a href="../logout.php">Logout</a>
			</div>
		</div>
	</div>
	<div class="limiter" style="background-color: black">
		<div class="container-table100">
			<div class="wrap-table100">
				
				<?php $beczka = $_SESSION['orders'][0]['id_order'];
						$in = $beczka;
						$f = 0;
						for($i=0;$i<$beczka;$i++){ 
				
						?>
				<h3 style="display: inline; ">ORDER: <?php echo $_SESSION['orders'][$f]['id_order']?></h3>
				<h3 style="display: inline; margin-left: 20%;"><a href="users.php?get=<?php echo $_SESSION['orders'][$f]['id_user']?>">ADDRESS</a></h3>
				<h3 style="display: inline; margin-left: 20%;">ORDER STATUS: 
																		<?php if($_SESSION['orders'][$f]['status'])
																				echo '<span style="color: green">SEND';
																				else echo '<span style="color: red">NOT SEND';
																		?></h3>
				<?php if(!$_SESSION['orders'][$f]['status']) 
					echo '<a style="margin-left: 85%;" href="orders.php?id="'.$_SESSION['orders'][$f]['id_order'].'">Update status</a>';
					
				?>
					<div class="table100 ver3 m-b-110">
						<div class="table100-head">
							<table>
								<thead>
									<tr class="row100 head">
										
										<th class="cell100 column1">First and Last Name</th>
										<th class="cell100 column2">Item</th>
										<th class="cell100 column3">Quantity</th>
										<th class="cell100 column4">Total</th>
										
									</tr>
								</thead>
							</table>
						</div>
						<?php for($j=$f;$j<count($_SESSION['orders']);$j++){ 
								
								if($in != $_SESSION['orders'][$j]['id_order']) break;
								
						?>
							<div class="table100-body js-pscroll">
								<table>
									<tbody>
										<tr class="row100 body">
											
											<td class="cell100 column1"><?php echo $_SESSION['orders'][$j]['first']."&nbsp;".$_SESSION['orders'][$i]['last'] ?></td>
											<td class="cell100 column2"><?php echo $_SESSION['orders'][$j]['title'] ?></td>
											<td class="cell100 column3"><?php echo $_SESSION['orders'][$j]['quantity'] ?></td>
											<td class="cell100 column4"><?php echo $_SESSION['orders'][$j]['id_user'] ?></td>
											
											
										</tr>

									</tbody>
								</table>
								
							</div>
							
						<?php 
							$f++;
						}
							$in--;
							
							
						?>
					</div>
					
				<?php 
					
				} ?>
				</div>
		</div>
	</div>


<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			var ps = new PerfectScrollbar(this);

			$(window).on('resize', function(){
				ps.update();
			})
		});
			
		
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>