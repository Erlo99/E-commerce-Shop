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
													
													$sql = sprintf("SELECT * FROM products");
													@$connection->query($sql);
													$result = @$connection->query($sql);
													}
													if($result){
														$product = $result->num_rows;
														
															if($product>0)
																
																	for($i=0;$i<$product;$i++){
																	$row = $result->fetch_assoc();
																	
																	$items = array(
																		
																		'id' =>$row['id_product'],
																		'title' => $row['title'],
																		'img' => $row['img'],
																		'price' => $row['Price'],
																		'stock' => $row['Stock'],
																		'desc' => $row['description'],
																		);
																		
																	$_SESSION["products"][$i] = $items;
																	}
																		
																	}
																$result->close();
																 
														if(isset($_POST['update'])){
															$sql = sprintf("UPDATE products SET title = '".$_POST['title']."',
																	description = '".$_POST['desc']."', Price = '".$_POST['price']."',
																	img = '".$_POST['img']."', Stock = '".$_POST['stock']."'
																	WHERE id_product=".$_POST['id']);
															@$connection->query($sql);
															header('Location: products.php');
														}
														
														if(isset($_POST['add'])){
															
															$sql = sprintf("INSERT INTO products VALUES (NULL,'".$_POST['title']."','".$_POST['desc']."','".$_POST['price']."',".$_POST['stock'].",'".$_POST['img']."')");
															@$connection->query($sql);
															header('Location: products.php');
														}
														
														if(isset($_POST['delete'])){
															
															$sql = sprintf("DELETE FROM products WHERE id_product=".$_POST['id']);
															@$connection->query($sql);
															header('Location: products.php');
															for($i = 0;$i<count($_SESSION["products"]);$i++){
																if($_POST['id'] == $_SESSION["products"][$i]['id']) {
																	unset($_SESSION["products"][$i]);
																	break;
																}
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
	<title>Products</title>
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
	<link rel="stylesheet" type="text/css" href="css/mainproduct.css">
<!--===============================================================================================-->
</head>
<body >
	<div class="jumbotron text-center">
		<h1>PRODUCTS</h1>
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
									<th class="cell100 column1">Title </th>
									<th class="cell100 column2">Description</th>
									<th class="cell100 column3">Image</th>
									<th class="cell100 column4">Price</th>
									<th class="cell100 column5">Stock</th>
								</tr>
							</thead>
						</table>
					</div>
					<?php 
					$pr = 0;
						foreach($_SESSION["products"] as $key => $val){
							$pr++;
					?>
					<div class="table100-body js-pscroll">
						<table>
							<tbody>
							<form id="edit" action="products.php" method="POST">
								<tr class="row100 body">
								<h3 style="display: inline; color: white;">Product: <?php echo $pr ?> </h3>
								<input type="submit" class="btn btn-warning" name="update" style="display: inline;" value="Update">
								<input type="submit" class="btn btn-danger" name="delete" style="display: inline;" value="Delete">
									<td class="cell100 column1"><input type="text" name="title" value="<?php echo $val['title'] ?>"></td>
									<td class="cell100 column2"><textarea  cols="60" rows="8" name="desc"><?php echo $val['desc']?></textarea></td>
									<td class="cell100 column3"><img src="<?php echo $val['img'] ?>" class="img-fluid"><input type="text" name="img" value="<?php  echo $val['img'] ?>"></td>
									<td class="cell100 column4"><input style="width: 70%" type="text" name="price" value="<?php echo $val['price'] ?>"></td>
									<td class="cell100 column5"><input style="width: 50%" type="text" name="stock" value="<?php echo $val['stock'] ?>"></td>
									<input type="hidden" name="id" value="<?php echo $val['id'] ?>">
								</tr>
							</form>
							</tbody>
						</table>
					</div>
					<?php 
					}
					?>
							
							<form action="products.php"  method="POST" style="background-color: lightgrey; padding: 10%">
							  <div class="form-group" >
								<label>Title</label>
								<input type="text"  class="form-control" name="title" value="">
							  </div>
							   <div class="form-group">
								<label>Description</label>
								<textarea  cols="60" rows="8" name="desc"  class="form-control"></textarea>
							  </div>
							  <div class="form-group">
								<img src="" class="img-fluid"><p>Link:</p><input  class="form-control" type="text" name="img">
							  </div>
							  <div class="form-group">
								<label>Price</label>
								<input  class="form-control" style="width: 70%" type="text" name="price" value="">
							  </div>
							  <div class="form-group">
								<label>stock</label>
								<input  class="form-control" style="width: 50%" type="text" name="stock" value="">
							  </div>
							  <div class="form-group">
								<input type="submit" class="btn btn-success" style="display: inline;" name="add" value="add">
							  </div>
							
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