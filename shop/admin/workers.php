<?php 
		session_start();
	
	
	if((!isset($_SESSION['loggedAdmin'])) && !($_SESSION['loggedAdmin']==true)){
		header('Location: loginAdmin.php');
		exit();
	}
	
	define("SITE_ROOT", "../");
	require (SITE_ROOT."/connect.php");
											
		
												
												try{
													$connection = @new mysqli($host, $db_user, $db_password, $db_name, $port);
												if($connection->connect_errno!=0){
													throw new Exception(mysqli_connect_errno());
												}
												else {
													
													$sql = sprintf("SELECT * FROM workers");
													@$connection->query($sql);
													$result = @$connection->query($sql);
													
													if($result){
														$product = $result->num_rows;
														
															if($product>0)
																
																	for($i=0;$i<$product;$i++){
																	$row = $result->fetch_assoc();
																	
																	$items = array(
																		
																		'id' =>$row['id_worker'],
																		'first' => $row['first'],
																		'last' => $row['last'],
																		'login' => $row['login'],
																		);
																		
																	$_SESSION["workers"][$i] = $items;
																	}
																		
																	}
																$result->close();
																
														}
														if(isset($_GET['delete'])){
															$query = "DELETE FROM workers WHERE id_worker = ".$_GET['delete'];
															$result = @$connection->query($query);	
															if($result) $_SESSION['removed'] = '<span style="color: green; text-align: center" > Worker has been removed</span>';		
															else $_SESSION['removed'] = '<span style="color: green;"> Something went wrong!</span>';
															header('Location: workers.php');
															
														}
														$connection->close();
													
												} catch (Exception $e){
													echo 'Server error';
													echo $e;
												}
												
												//add new worker
												
												
												if(isset($_POST['login'])){
													
													try{
														
													$connection = @new mysqli($host, $db_user, $db_password, $db_name, $port);
													if($connection->connect_errno!=0){
														throw new Exception(mysqli_connect_errno());
													}
													else {
														$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
														$sql = sprintf("INSERT INTO workers VALUES (NULL, '".$_POST['first']."', '".$_POST['last']."', 'pracownik', '".$_POST['login']."', '".$password_hash."')");
														@$connection->query($sql);
														
																}
															$connection->close();
														header('Location: workers.php');
													} catch (Exception $e){
														echo 'Server error';
														echo $e;
													}
												}
												
											?>
											
											
<!DOCTYPE html>
<html lang="en" >
<head>
	<title>Workers</title>
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
		<h1>WORKERS</h1>
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
									<th class="cell100 column1">Fullname</th>
									<th class="cell100 column2">login</th>
									<th class="cell100 column3">id</th>
									<th class="cell100 column4"></th>
									
								</tr>
							</thead>
						</table>
					</div>
					<?php 
						foreach($_SESSION["workers"] as $key => $val){
					?>
					<div class="table100-body js-pscroll">
						<table>
							<tbody>
								<tr class="row100 body">
									<td class="cell100 column1"><?php echo $val['first']."&nbsp;".$val['last'] ?></td>
									<td class="cell100 column2"><?php echo $val['login'] ?></td>
									<td class="cell100 column3"><?php echo $val['id'] ?></td>
									<td class="cell100 column4"><a href="workers.php?delete=<?php echo $val['id'] ?>"><button type="button" class="btn btn-danger">Delete</button></a></td>
								</tr>
							</tbody>
							
						</table>
					</div>
					<?php 
					}
					
					?>
				</div>
					<?php 
								if(isset($_SESSION['removed']) && isset($_GET['delete']) && $_GET['delete'] == $val['id']){
									echo $_SESSION['removed'];
									
									for($i = 0;$i<count($_SESSION["workers"]);$i++){
										if($_GET['delete'] == $_SESSION["workers"][$i]['id']) {
											unset($_SESSION["workers"][$i]);
											break;
										}
									}
								}
							?>
				</div>
							
					<form action="workers.php"  method="POST" style="background-color: lightgrey; padding: 10%">
						
					  <div class="form-group" >
						<label>First Name</label>
						<input type="text" class="form-control" name="first" placeholder="Enter First Name">
					  </div>
					   <div class="form-group">
						<label>First Name</label>
						<input type="text" class="form-control" name="last" placeholder="Enter Last Name">
					  </div>
					  <div class="form-group">
						<label>Login</label>
						<input type="text" class="form-control" name="login" placeholder="Login">
					  </div>
					  <div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="password" placeholder="Password">
					  </div>
					  
					  <input type="submit" class="btn btn-primary">
					
					</form>
				
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