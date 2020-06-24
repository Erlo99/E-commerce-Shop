<?php
	session_start();
	if(!(isset($_SESSION["shopping_cart"])) || empty($_SESSION["shopping_cart"])){
		//header('Location: cart.php');

		exit();
	}
	
	require_once "connect.php";
		
		try{
			$connection = @new mysqli($host, $db_user, $db_password, $db_name, $port);
		if($connection->connect_errno!=0){
			throw new Exception(mysqli_connect_errno());
		}
		else {
			
			if((isset($_POST['email']) && isset($_POST['password'])) || (isset($_SESSION['logged']) && $_SESSION['logged']==true)){
				if(isset($_POST['email']) && isset($_POST['password'])){
					$login = $_POST['email'];
					$password = $_POST['password'];
					$login = htmlentities($login, ENT_QUOTES, "UTF-8");
				
			
			
		//search in db
			$sql = sprintf("SELECT * FROM users WHERE email='%s'",
					mysqli_real_escape_string($connection,$login));
				} else if (isset($_SESSION['loggedEmail'])){
					$sql = sprintf("SELECT * FROM users WHERE email='%s'",
					mysqli_real_escape_string($connection,$_SESSION['loggedEmail']));
				}
				
			$result = @$connection->query($sql);
			
			if($result){
				$many_users = $result->num_rows;
					if($many_users>0){
						$row = $result->fetch_assoc();
						
						if(isset($password) && password_verify($password, $row['password'])){
						$_SESSION['logged'] = true;
						
						$_SESSION['shipping'] = array(
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
							'phone' => $row['phone'],
						);
						} else {
							$_SESSION['shipping'] = array(
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
							'phone' => $row['phone'],
							);
						}
						
						
						
						
						unset($_SESSION['wrong']);
						$_SESSION['first'] = $row['first'];
						$result->close();
						//header('Location: ' . $_SERVER['HTTP_REFERER'])
					} else {
						$_SESSION['wrong'] =  '<span style="color:red">Wrong email or password</span>';
						
					}
				} else {
					$_SESSION['wrong'] =  '<span style="color:red">Wrong email or password</span>';
					
				}
			}
			
			
				$connection->close();
		}
		} catch (Exception $e){
			echo 'Server error';
			echo $e;
		}
	
	
	

?>

<!doctype html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Checkout</title>
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
                                <?php
									if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true)){
										echo '<li>  <p>Welcome '.$_SESSION['first'].' </p></li>
											
											<li> <a href="logout.php?action=checkout" style="color:black">Logout</a></li>';
									} else {
									echo '<li> <a href="login.php"><span class="flaticon-user"></span></a></li>';
									}
								?>
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
                                <h2>Checkout</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--================Checkout Area =================-->
        <section class="checkout_area section_padding">
          <div class="container">
		  
            
               <?php 
					if((!isset($_SESSION['logged']))){
						echo '<div class="returning_customer">
							  <p>
								If you have shopped with us before, please enter your details in the
								boxes below. If you are a new customer, please proceed to the
								Billing & Shipping section.
							  </p>
							   
							  <form class="row contact_form" action="checkout.php" method="post" >
								<div class="col-md-6 form-group p_star">
								  <input type="text" class="form-control" id="name" name="email" placeholder="Email"/>
								  <input type="hidden" class="form-control" name="redCheck"/>
								</div>
								<div class="col-md-6 form-group p_star">
								  <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
								  
								</div>';
						if(isset($_SESSION['wrong'])) 
							echo $_SESSION['wrong'];
											
								echo '<div class="col-md-12 form-group">
								  <button type="submit" value="submit" class="btn_3">
									 log in
								  </button>
								</div>
							  </form>
							</div>';
					} 
				?>
				
            <div class="billing_details">
			
              <div class="row">
                <div class="col-lg-8">
                  <h3>Shipping Details</h3>
                  <form class="row contact_form" action="send.php" method="post" novalidate="novalidate">
				  <input type="hidden" value="<?php echo $_SESSION['shipping']['id'] ?>" name="id">
                    <div class="col-md-6 form-group p_star">
						<?php 
							if(isset($_SESSION['shopped']['first']) && $_SESSION['shopped']['first'] != NULL)
								echo '<input type="text" class="form-control" id="first" name="first" value="'.$_SESSION['shopped']['first'].'"/>';
							else if(isset($_SESSION['shipping']['first']) && $_SESSION['shipping']['first'] != NULL)
								echo '<input type="text" class="form-control" id="first" name="first" value="'.$_SESSION['shipping']['first'].'"/>';
							else echo '<input type="text" class="form-control" id="first" name="first" placeholder="First Name"/>';
							if((!isset($_SESSION['shopped']['first']) || $_SESSION['shopped']['first'] == '') && isset($_SESSION['bad'])){
								echo $_SESSION['bad'];
							} 
						?>
                    </div>
                    <div class="col-md-6 form-group p_star">
						<?php 
							if(isset($_SESSION['shopped']['last']) && $_SESSION['shopped']['last'] != NULL)
								echo '<input type="text" class="form-control" id="last" name="last" placeholder="Last name" value="'.$_SESSION['shopped']['last'].'"/>';
							else if(isset($_SESSION['shipping']['last']) && $_SESSION['shipping']['last'] != NULL)
								echo '<input type="text" class="form-control" id="last" name="last" placeholder="Last name" value="'.$_SESSION['shipping']['last'].'"/>';
							else echo '<input type="text" class="form-control" id="last" name="last" placeholder="Last name"/>';
							if((!isset($_SESSION['shopped']['last']) || $_SESSION['shopped']['last'] == '') && isset($_SESSION['bad'])){
								echo $_SESSION['bad'];
							} 
						?>
                      
                      
                    </div>
                    <div class="col-md-12 form-group">
					
                      <input type="text" class="form-control" id="company" name="company" placeholder="Company name" />
                    </div>
                    <div class="col-md-6 form-group p_star">
						<?php 
							if(isset($_SESSION['shopped']['phone']) && $_SESSION['shopped']['phone'] != NULL)
								echo '<input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" value="'.$_SESSION['shopped']['phone'].'"/>';
							else if(isset($_SESSION['shipping']['phone']) && $_SESSION['shipping']['phone'] != NULL)
								echo '<input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number" value="'.$_SESSION['shipping']['phone'].'"/>';
							else echo '<input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number"/>';
							if((!isset($_SESSION['shopped']['phone']) || $_SESSION['shopped']['phone'] == '') && isset($_SESSION['bad'])){
								echo $_SESSION['bad'];
								if(isset($_SESSION['e_number'])) echo $_SESSION['e_number'];
							} 
						?>
                      
                      
                    </div>
                    <div class="col-md-6 form-group p_star">
						<?php 
							if(isset($_SESSION['shopped']['email']) && $_SESSION['shopped']['email'] != NULL)
								echo '<input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="'.$_SESSION['shopped']['email'].'"/>';
							else if(isset($_SESSION['shipping']['email']) && $_SESSION['shipping']['email'] != NULL)
								echo '<input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="'.$_SESSION['shipping']['email'].'"/>';
							else echo '<input type="text" class="form-control" id="email" name="email" placeholder="Email Address"/>';
							if((!isset($_SESSION['shopped']['email']) || $_SESSION['shopped']['email'] == '') && isset($_SESSION['bad'])){
								echo $_SESSION['bad'];
								if(isset($_SESSION['e_email'])) echo $_SESSION['e_email'];
							} 
						?>
                      
                      
                    </div>
                    <div class="col-md-12 form-group p_star">
						<?php 
							if(isset($_SESSION['shopped']['country']) && $_SESSION['shopped']['country'] != NULL)
								echo '<input type="text" class="form-control" id="country" name="country" placeholder="Country" value="'.$_SESSION['shopped']['country'].'"/>';
							else if(isset($_SESSION['shipping']['country']) && $_SESSION['shipping']['country'] != NULL)
								echo '<input type="text" class="form-control" id="country" name="country" placeholder="Country" value="'.$_SESSION['shipping']['country'].'"/>';
							else echo '<input type="text" class="form-control" id="country" name="country" placeholder="Country"/>';
							if((!isset($_SESSION['shopped']['country']) || $_SESSION['shopped']['country'] == '') && isset($_SESSION['bad'])){
								echo $_SESSION['bad'];
							} 
						?>
                      
                    </div>
                    <div class="col-md-12 form-group p_star">
						<?php 
							if(isset($_SESSION['shopped']['adress1']) && $_SESSION['shopped']['adress1'] != NULL)
								echo '<input type="text" class="form-control" id="adress1" name="adress1" placeholder="Address line 01" value="'.$_SESSION['shopped']['adress1'].'"/>';
							else if(isset($_SESSION['shipping']['adress1']) && $_SESSION['shipping']['adress1'] != NULL)
								echo '<input type="text" class="form-control" id="adress1" name="adress1" placeholder="Address line 01" value="'.$_SESSION['shipping']['adress1'].'"/>';
							else echo '<input type="text" class="form-control" id="adress1" name="adress1" placeholder="Address line 01"/>';
							if((!isset($_SESSION['shopped']['adress1']) || $_SESSION['shopped']['adress1'] == '') && isset($_SESSION['bad'])){
								echo $_SESSION['bad'];
							} 
						?>
                      
                      
                    </div>
                    <div class="col-md-12 form-group p_star">
						<?php 
							if(isset($_SESSION['shopped']['adress2']) && $_SESSION['shopped']['adress2'] != NULL)
								echo '<input type="text" class="form-control" id="adress2" name="adress2" placeholder="Address line 02" value="'.$_SESSION['shopped']['adress2'].'"/>';
							else if(isset($_SESSION['shipping']['adress2']) && $_SESSION['shipping']['adress2'] != NULL)
								echo '<input type="text" class="form-control" id="adress2" name="adress2" placeholder="Address line 02" value="'.$_SESSION['shipping']['adress2'].'"/>';
							else echo '<input type="text" class="form-control" id="adress2" name="adress2" placeholder="Address line 02" />';
						
						?>
                      
                      
                    </div>
                    <div class="col-md-12 form-group p_star">
						<?php 
							if(isset($_SESSION['shopped']['city']) && $_SESSION['shopped']['city'] != '')
								echo '<input type="text" class="form-control" id="city" name="city" placeholder="Town/City" value="'.$_SESSION['shopped']['city'].'"/>';
							
							else if(isset($_SESSION['shipping']['city']) && $_SESSION['shipping']['city'] != NULL)
								echo '<input type="text" class="form-control" id="city" name="city" placeholder="Town/City" value="'.$_SESSION['shipping']['city'].'"/>';
							
							else echo '<input type="text" class="form-control" id="city" name="city" placeholder="Town/City"/>';
							if((!isset($_SESSION['shopped']['city']) || $_SESSION['shopped']['city'] == '') && isset($_SESSION['bad'])){
								echo $_SESSION['bad'];
							} 
						?>
                      
                      
                    </div>
                    <div class="col-md-12 form-group p_star">
						<?php 
							if(isset($_SESSION['shopped']['district']) && $_SESSION['shopped']['district'] != '')
								echo '<input type="text" class="form-control" id="district" name="district" placeholder="District" value="'.$_SESSION['shopped']['district'].'"/>';
							
							else if(isset($_SESSION['shipping']['district']) && $_SESSION['shipping']['district'] != NULL)
								echo '<input type="text" class="form-control" id="district" name="district" placeholder="District" value="'.$_SESSION['shipping']['district'].'"/>';
							 
								else echo '<input type="text" class="form-control" id="district" name="district" placeholder="District"/>';
							if((!isset($_SESSION['shopped']['district']) || $_SESSION['shopped']['district'] == '') && isset($_SESSION['bad'])){
								echo $_SESSION['bad'];
							} 
						?>
                      
                    </div>
                    <div class="col-md-12 form-group">
						<?php 
							 if(isset($_SESSION['shopped']['zip']) && $_SESSION['shopped']['zip'] != '')
								echo '<input type="text" class="form-control" id="zip" name="zip" placeholder="Postcode/ZIP"  value="'.$_SESSION['shopped']['zip'].'"/>';
							else if(isset($_SESSION['shipping']['zip']) && $_SESSION['shipping']['zip'] != NULL)
								echo '<input type="text" class="form-control" id="zip" name="zip" placeholder="Postcode/ZIP"  value="'.$_SESSION['shipping']['zip'].'"/>';
							else echo '<input type="text" class="form-control" id="zip" name="zip" placeholder="Postcode/ZIP" />';
							if((!isset($_SESSION['shopped']['zip']) || $_SESSION['shopped']['zip'] == '') && isset($_SESSION['bad'])){
								echo $_SESSION['bad'];
							} 
						?>
                      
                    </div>
					<div class="col-md-12 form-group">
					
					</div>
                    <h3>Card Information</h3>
                    <div class="billing_details" style="margin-left: 10%;">
						<div class="row">
							<div class="col-md-12 form-group p_star">
							<?php 	
								if(isset($_SESSION['shipping']['card']) && $_SESSION['shipping']['card'] != NULL)
									echo '<input type="text" class="form-control" id="card" name="card" placeholder="Card Number" value="'.$_SESSION['shipping']['card'].'"/>';
								else echo '<input type="text" class="form-control" id="card" name="card" placeholder="Card Number"/>';
								if((!isset($_SESSION['shopped']['card']) || $_SESSION['shopped']['zip'] == '') && isset($_SESSION['e_card'])){
									echo $_SESSION['e_card'];
								} 
							?>
							  
							  
							</div>
							<div class="col-md-12 form-group p_star">
							<?php 
								if(isset($_SESSION['shipping']['cvv']) && $_SESSION['shipping']['cvv'] != NULL)
									echo '<input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV" value="'.$_SESSION['shipping']['cvv'].'"/>';
								else echo '<input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV"/>';
								if((!isset($_SESSION['shopped']['cvv']) || $_SESSION['shopped']['cvv'] == '') && isset($_SESSION['e_cvv'])){
									echo $_SESSION['e_cvv'];
								} 
							?>
							  
							  
							</div>
							<div class="col-md-2 form-group p_star">
							<?php 
								if(isset($_SESSION['shipping']['month']) && $_SESSION['shipping']['month'] != NULL)
									echo '<input type="text" class="form-control" id="month" name="month" placeholder="month" value="'.$_SESSION['shipping']['month'].'"/>';
								else echo '<input type="text" class="form-control" id="month" name="month" placeholder="month"/>';
								if((!isset($_SESSION['shopped']['month']) || $_SESSION['shopped']['month'] == '') && isset($_SESSION['e_month'])){
									echo $_SESSION['e_month'];
								} 
							?>
							  
							</div>
							<div class="col-md-2 form-group p_star">
							<?php
								if(isset($_SESSION['shipping']['year']) && $_SESSION['shipping']['year'] != NULL)
									echo '<input type="text" class="form-control" id="year" name="year" placeholder="year" value="'.$_SESSION['shipping']['year'].'"/>';
								else echo '<input type="text" class="form-control" id="year" name="year" placeholder="year"/>';
								if((!isset($_SESSION['shopped']['year']) || $_SESSION['shopped']['year'] == '') && isset($_SESSION['e_card'])){
									echo $_SESSION['e_year'];
								} 
							?>
							  
							</div>
						</div> 
                    </div>
                  
                </div>
                <div class="col-lg-4">
                  <div class="order_box">
                    <h2>Your Order</h2>
					
                    <ul class="list">
                      <li>
                        
                          <span>Cart</span>
                        
                      </li>
						<?php
							if(!empty($_SESSION["shopping_cart"])){
						
								foreach($_SESSION["shopping_cart"] as $keys => $values)
								{
						?>
                      <li>
                        <a ><?php echo $values["title"]; ?>
                          <span class="middle">x<?php echo $values["quantity"];?></span>
                          <span class="last">$<?php echo $values["price"]; ?></span>
                        </a>
                      </li>
                      <?php 
								}
							}
					?>
                    </ul>
					
                    <ul class="list list_2">
                      
                      <li>
                        <a>Total
                          <span><?php	if(isset($_SESSION['total'])) echo $_SESSION['total']; ?></span>
                        </a>
                      </li>
					  
                    </ul>
                    
                    
                    
                    <button type="submit"  name="submit" class="btn_3">
									Place Order
								  </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
		  </form>
        </section>
        <!--================End Checkout Area =================-->
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
  <script src="./assets/js/jquery.magnific-popup.js"></script>

  <!-- Scroll up, nice-select, sticky -->
  <script src="./assets/js/jquery.scrollUp.min.js"></script>
  <script src="./assets/js/jquery.nice-select.min.js"></script>
  <script src="./assets/js/jquery.sticky.js"></script>
  
  <!-- contact js -->
  <script src="./assets/js/contact.js"></script>
  <script src="./assets/js/jquery.form.js"></script>
  <script src="./assets/js/jquery.validate.min.js"></script>
  <script src="./assets/js/mail-script.js"></script>
  <script src="./assets/js/jquery.ajaxchimp.min.js"></script>
      
  <!-- Jquery Plugins, main Jquery -->	
  <script src="./assets/js/plugins.js"></script>
  <script src="./assets/js/main.js"></script>
  
</body>
</html>