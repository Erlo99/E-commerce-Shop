<?php
	session_start();
	
	
	
	if(isset($_POST['add_cart'])){


	
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
					
					
						
					if(isset($_SESSION["shopping_cart"]))
					{	
						if(isset($_POST['many'])) $quanti = $_POST['many'];
						else $quanti = $_GET['quantity'];
						
						$count = count($_SESSION["shopping_cart"]);
						$items = array(
							"id" => $row['id_product'],
							"img" => $row['img'], 
							"title" => $row['title'], 
							"price" => $row['Price'],
							"quantity" => $quanti);
							
						$_SESSION["shopping_cart"][$count] = $items;
								
								
								if ($_POST['many']>10){
									$_SESSION['limit'] = '<span style="color:red">limit 10</span>';
									header('Location: ' . $_SERVER['HTTP_REFERER']);
									unset($_SESSION["shopping_cart"][$count]);
									exit();
								}
								$oos = $row['Stock']-$quanti;
								if ($oos<1){
									$_SESSION['oos'] = '<span style="color:red">Only '.$row['Stock'].' left in stock</span>';
									header('Location: ' . $_SERVER['HTTP_REFERER']);
									unset($_SESSION["shopping_cart"][$count]);
									exit();
								}
								
						for($i=0;$i<$count;$i++){
							if(reset($_SESSION["shopping_cart"][$i]) == reset($items)){
								
								$_SESSION['already_added'] =  '<span style="color:red">Item already added &nbsp;&nbsp;</span>';
								$_SESSION['already_id'] = $row['id_product'];
								
								header('Location: ' . $_SERVER['HTTP_REFERER']);
								unset($_SESSION["shopping_cart"][$count]);
								exit();
								
							}
						}
						$left = $row['Stock'] - $quanti;
						$query = "UPDATE products 
								SET Stock='".$left."' 
								WHERE id_product='".$row['id_product']."'";
						mysqli_query($connection, $query);
					}
					else
					{	
					
						if(isset($_POST['many'])) $quanti = $_POST['many'];
						else $quanti = $_GET['quantity'];
						$items = array(
							"id" => $row['id_product'],
							"img" => $row['img'], 
							"title" => $row['title'], 
							"price" => $row['Price'], 
							"quantity" => $quanti);
						$_SESSION["shopping_cart"][0] = $items;
						if ($_POST['many']>10){
									$_SESSION['limit'] = '<span style="color:red">limit 10</span>';
									header('Location: ' . $_SERVER['HTTP_REFERER']);
									unset($_SESSION["shopping_cart"][0]);
									exit();
								}
								$oos = $row['Stock']-$quanti;
								if ($oos<1){
									$_SESSION['oos'] = '<span style="color:red">Only '.$row['Stock'].' left in stock</span>';
									header('Location: ' . $_SERVER['HTTP_REFERER']);
									unset($_SESSION["shopping_cart"][0]);
									exit();
								}
						
						$left = $row['Stock'] - $quanti;
						$query = "UPDATE products 
								SET Stock='".$left."' 
								WHERE id_product='".$row['id_product']."'";
						mysqli_query($connection, $query);						
					}
					
					$result->close();
					header('Location: ' . $_SERVER['HTTP_REFERER']);
				
			} 
		}
		
			$connection->close();
		}
	} catch (Exception $e){
		echo 'Server error';
		echo $e;
	}
	}
	if(isset($_GET["delete"]))
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
			if($values["id"] == $_GET["delete"])
			{
				unset($_SESSION["shopping_cart"][$keys]);
				 $_SESSION['total'] = $_SESSION['total'] - $values["price"];
				//echo '<script>alert("Item Removed")</script>';
				//echo '<script>window.location="index.php"</script>';
				//unset($_SESSION["delete"]);
			}
		}

	}
	
?>



<!doctype html>
<html lang="zxx">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Watch shop | eCommers</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="manifest" href="site.webmanifest">
  <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

  <!-- CSS here -->
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
      <link rel="stylesheet" href="assets/css/flaticon.css">
      <link rel="stylesheet" href="assets/css/slicknav.css">
      <link rel="stylesheet" href="assets/css/animate.min.css">
      <link rel="stylesheet" href="assets/css/magnific-popup.css">
      <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/slick.css">
      <link rel="stylesheet" href="assets/css/nice-select.css">
      <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="menu-wrapper">
                        <!-- Logo -->
                        <div class="logo">
                            <a href="index.php"><img src="assets/img/logo/logo.png" alt=""></a>
                        </div>
                        <!-- Main-menu -->
                        <div class="main-menu d-none d-lg-block">
                            <nav>                                                
                                <ul id="navigation">  
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="shop.php">shop</a></li>
                                    <li><a href="about.php">about</a></li>
                                    <li><a href="contact.php">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                        <!-- Header Right -->
                        <div class="header-right">
                            <ul>
                                <li> <a href="login.php"><span class="flaticon-user"></span></a></li>
                                <li><a href="cart.php"><span class="flaticon-shopping-cart"></span></a> </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
  <main>
      <!-- Hero Area Start-->
      <div class="slider-area ">
          <div class="single-slider slider-height2 d-flex align-items-center">
              <div class="container">
                  <div class="row">
                      <div class="col-xl-12">
                          <div class="hero-cap text-center">
                              <h2>Cart List</h2>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!--================Cart Area =================-->
      <section class="cart_area section_padding">
        <div class="container">
          <div class="cart_inner">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead>
                <tbody>
				<?php
				if(!empty($_SESSION["shopping_cart"]))
					{
						$total = 0;
						
						foreach($_SESSION["shopping_cart"] as $keys => $values)
						{
					?>
                  <tr>
                    <td>
                      <div class="media">
                        <div class="d-flex">
                          <img src="<?php echo $values["img"]; ?>" alt="" />
                        </div>
                        <div class="media-body">
                          <p><?php echo $values["title"]; ?></p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <h5><?php echo $values["price"]; ?></h5>
                    </td>
                    <td>
                      <div>
                    
							<p style="margin-bottom: 0; color: #415094;"><?php echo $values["quantity"];?></p>
						
				
                        
                      </div>
					  <?php $total += ($values["price"] * $values["quantity"]); ?>
                    </td>
                    <td>
                      <h5><?php echo $total; ?></h5>
                    </td>
					<td>
                      <a href="cart.php?delete=<?php echo $values["id"] ?>"  name="delete" style="color:red">Delete &nbsp;</a>
						
						<!--</form>-->
                    </td>
                  </tr>
				  
                  <?php
							 
							 $_SESSION['total'] = $total;
						}
					} else {
						echo '<span style="color:red">No items added</span>';
					}
					?>
                  
                  <tr>
                    <td></td>
                    <td></td>
                    <td>
                      <h5>Subtotal</h5>
                    </td>
					
                    <td>
                     <h5><?php  if(isset($_SESSION['total']))
							echo $_SESSION['total'];
						 ?></h5>
                    </td>
                  </tr>
                  
                </tbody>
              </table>
			  
              <div class="checkout_btn_inner float-right">
			  
                <a class="btn_1" href="shop.php">Continue Shopping</a>
                <a class="btn_1 checkout_btn_1" href="checkout.php">Proceed to checkout</a>
              </div>
            </div>
          </div>
      </section>
      <!--================End Cart Area =================-->
  </main>
  <footer>
      <!-- Footer Start-->
      <div class="footer-area footer-padding">
          <div class="container">
              <div class="row d-flex justify-content-between">
                  <div class="col-xl-3 col-lg-3 col-md-5 col-sm-6">
                      <div class="single-footer-caption mb-50">
                          <div class="single-footer-caption mb-30">
                              <!-- logo -->
                              <div class="footer-logo">
                                  <a href="index.php"><img src="assets/img/logo/logo2_footer.png" alt=""></a>
                              </div>
                              <div class="footer-tittle">
                                  <div class="footer-pera">
                                      <p>Asorem ipsum adipolor sdit amet, consectetur adipisicing elitcf sed do eiusmod tem.</p>
                              </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
              <!-- Footer bottom -->
              <div class="row align-items-center">
                  <div class="col-xl-7 col-lg-8 col-md-7">
                      <div class="footer-copy-right">
                          <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>                 
                      </div>
                  </div>
                  <div class="col-xl-5 col-lg-4 col-md-5">
                      <div class="footer-copy-right f-right">
                          <!-- social -->
                          <div class="footer-social">
                              <a href="#"><i class="fab fa-twitter"></i></a>
                              <a href="https://www.facebook.com/sai4ull"><i class="fab fa-facebook-f"></i></a>
                              <a href="#"><i class="fab fa-behance"></i></a>
                              <a href="#"><i class="fas fa-globe"></i></a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- Footer End-->
  </footer>
  <!--? Search model Begin -->
  <div class="search-model-box">
      <div class="h-100 d-flex align-items-center justify-content-center">
          <div class="search-close-btn">+</div>
          <form class="search-model-form">
              <input type="text" id="search-input" placeholder="Searching key.....">
          </form>
      </div>
  </div>
  <!-- Search model end -->

  <!-- JS here -->

  <script src="./assets/js/vendor/modernizr-3.5.0.min.js"></script>
  <!-- Jquery, Popper, Bootstrap -->
  <script src="./assets/js/vendor/jquery-1.12.4.min.js"></script>
  <script src="./assets/js/popper.min.js"></script>
  <script src="./assets/js/bootstrap.min.js"></script>
  <!-- Jquery Mobile Menu -->
  <script src="./assets/js/jquery.slicknav.min.js"></script>

  <!-- Jquery Slick , Owl-Carousel Plugins -->
  <script src="./assets/js/owl.carousel.min.js"></script>
  <script src="./assets/js/slick.min.js"></script>

  <!-- One Page, Animated-HeadLin -->
  <script src="./assets/js/wow.min.js"></script>
  <script src="./assets/js/animated.headline.js"></script>
  
  <!-- Scrollup, nice-select, sticky -->
  <script src="./assets/js/jquery.scrollUp.min.js"></script>
  <script src="./assets/js/jquery.nice-select.min.js"></script>
  <script src="./assets/js/jquery.sticky.js"></script>
  <script src="./assets/js/jquery.magnific-popup.js"></script>

  <!-- contact js -->
  <script src="./assets/js/contact.js"></script>
  <script src="./assets/js/jquery.form.js"></script>
  <script src="./assets/js/jquery.validate.min.js"></script>
  <script src="./assets/js/mail-script.js"></script>
  <script src="./assets/js/jquery.ajaxchimp.min.js"></script>
  
  <!-- Jquery Plugins, main Jquery -->	
  <script src="./assets/js/plugins.js"></script>
  <script src="./assets/js/main.js"></script>
  
  <script>
	function changeQuantity() {
	  var quan = document.getElementByName("many");
	  console.log(quan);
	}
</script>

</body>
</html>