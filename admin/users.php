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
													
													$sql = sprintf("SELECT * FROM users");
													@$connection->query($sql);
													$result = @$connection->query($sql);
													}
													if($result){
														$product = $result->num_rows;
														
															if($product>0)
																
																	for($i=0;$i<$product;$i++){
																	$row = $result->fetch_assoc();
																	
																	$items = array(
																		'id' => $row['id_user'],
																		'first' =>$row['first'],
																		'last' => $row['last'],
																		'email' => $row['email'],
																		'country' => $row['country'],
																		'adress1' => $row['adress1'],
																		'adress2' => $row['adress2'],
																		'city' => $row['city'],
																		'district' => $row['district'],
																		'zip' => $row['zip'],
																		'phone' => $row['phone'],);
																		
																	$_SESSION["userOrders"][$i] = $items;
																	}
																		
																	}
																$result->close();
																 
														$connection->close();
													
												} catch (Exception $e){
													echo 'Server error';
													echo $e;
												}
												
												
											?>
											
											
<!DOCTYPE html>
<html lang="en" >
<head>
	<title>Users</title>
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
		<h1>USERS</h1>
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
				<div class="table100 ver3 m-b-110">
					<div class="table100-head">
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column1">First/Last Name</th>
									<th class="cell100 column2">Address</th>
									<th class="cell100 column3">City and Postcode</th>
									<th class="cell100 column4">Country and District</th>
									<th class="cell100 column5">phone</th>
								</tr>
							</thead>
						</table>
					</div>
					<?php 
							if(!isset($_GET['get'])){
								foreach($_SESSION["userOrders"] as $key => $val){

					?>
					
					<div class="table100-body js-pscroll">
						<table>
							<tbody>
								<tr class="row100 body">
									<td class="cell100 column1"><?php echo $val['first']."&nbsp;".$val['last'] ?></td>
									<td class="cell100 column2"><?php echo $val['adress1']."&nbsp;".$val['adress2'] ?></td>
									<td class="cell100 column3"><?php echo $val['zip']."&nbsp;".$val['city'] ?></td>
									<td class="cell100 column4"><?php echo $val['district']."&nbsp;".$val['country'] ?></td>
									<td class="cell100 column5"><?php echo $val['phone'] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<?php 
								} 
							}  else {
								
										foreach($_SESSION["userOrders"] as $key => $val){
											if($_GET['get'] == $val['id']){
					?>					
										
										<div class="table100-body js-pscroll">
											<table>
												<tbody>
													<tr class="row100 body">
														<td class="cell100 column1"><?php echo $val['first']."&nbsp;".$val['last'] ?></td>
														<td class="cell100 column2"><?php echo $val['adress1']."&nbsp;".$val['adress2'] ?></td>
														<td class="cell100 column3"><?php echo $val['zip']."&nbsp;".$val['city'] ?></td>
														<td class="cell100 column4"><?php echo $val['district']."&nbsp;".$val['country'] ?></td>
														<td class="cell100 column5"><?php echo $val['phone'] ?></td>
													</tr>
												</tbody>
											</table>
										</div>
										
					<?php
											}
										}
									}
						
					?>
				</div>

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