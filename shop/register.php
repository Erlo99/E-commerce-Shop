<?php
	
	session_start();
	
	
	if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true)){
		header('Location: index.php');
		exit();
	}
	session_unset();
	
	if((isset($_SESSION['successful'])) && ($_SESSION['successful']==true)){
		$_SESSION['registered'] = "Your Account has been created ! <br>";
		
	}
	
	if(isset($_POST['email'])){
		$all_good = true;
		$email = $_POST['email'];
		$password = $_POST['password'];
		$passwordc = $_POST['passwordc'];
		$first = $_POST['first'];
		$last = $_POST['last'];
		$number = $_POST['number'];
		
		
		//Check first and last name 
		
		if(strlen($first)<2){
			$all_good = false;
			$_SESSION['e_first'] = '<span style="color:red">Name is too short</span>';
			
		} elseif (strlen($first)>20){
			$all_good = false;
			$_SESSION['e_first'] = '<span style="color:red">Name is too long</span>';
			
		} elseif (!preg_match('/^[a-zA-Z]+$/', $first)){
			$all_good = false;
			$_SESSION['e_first'] = '<span style="color:red">Must contain only letters</span>';
			
		}
		if(strlen($last)<2){
			$all_good = false;
			$_SESSION['e_last'] = '<span style="color:red">Last name is too short</span>';
			
		} elseif (strlen($last)>20){
			$all_good = false;
			$_SESSION['e_last'] = '<span style="color:red">Last name is too long</span>';
			
		} elseif (!preg_match('/^[a-zA-Z]+$/', $last)){
			$all_good = false;
			$_SESSION['e_last'] = '<span style="color:red">Must contain only letters</span>';
			
		}
		//check phone
		if(strlen($number)!=9){
			$all_good = false;
			$_SESSION['e_number'] = '<span style="color:red">Number must contain 9 digits</span>';
			
		} elseif (!preg_match('/^[1-9][0-9]*$/', $number)){
			$all_good = false;
			$_SESSION['e_number'] = '<span style="color:red">Only digits</span>';
			
		}
		
		//check email
		
		$emailS = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if(!filter_var($emailS, FILTER_VALIDATE_EMAIL) || $emailS != $email){
			$all_good = false;
			$_SESSION['e_email'] = '<span style="color:red">Wrong email adress</span>';
		}
		
		//check password
		
		
		if(strlen($password)<7 || strlen($password)>20){
			$all_good = false;
			$_SESSION['e_password'] = '<span style="color:red">Password must contain 8-20 characters</span>';
			
		} elseif ($password != $passwordc){
			$all_good = false;
			$_SESSION['e_passwordc'] = '<span style="color:red">Password must be the same</span>';
			
		}
		
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
		
		//are terms accepted
		if(!isset($_POST['terms'])){
			$all_good = false;
			$_SESSION['e_terms'] = '<p><span style="color:red">You have to accept terms and conditions</span><p>';
			
		}
		
		//captcha check
		
		$secret = "6Lf88KIZAAAAAJTzQqEJ__UvQuEBPNwU379f95z0";
		
		$resp = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		
		$check = json_decode($resp);
		
		if(!($check->success)){
			$all_good = false;
			$_SESSION['e_bot'] = '<p><span style="color:red">Prove you are not a bot</span><p>';
			
		}
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		
		try{
			$connection = @new mysqli($host, $db_user, $db_password, $db_name, $port);
			if($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			} else {
				//does email exist
				$result = $connection->query("SELECT id_user FROM users WHERE email='$email'");
				
				if(!$result) throw new Exception($connection->error);
				if($result->num_rows>0){
					$all_good = false;
					$_SESSION['e_email'] = '<span style="color:red">Email already registered</span>';
		
				}
				//does number exist
				$result = $connection->query("SELECT id_user FROM users WHERE phone='$number'");
				
				if(!$result) throw new Exception($connection->error);
				if($result->num_rows>0){
					$all_good = false;
					$_SESSION['e_number'] = '<span style="color:red">Number already in use</span>';
		
				}
			
				if($all_good){
					if($connection->query("INSERT INTO users(id_user,first,last,password, email, phone) VALUES (NULL, '$first', '$last', '$password_hash', '$email','$number')")){
						$_SESSION['successful'] = true;
						
						header('Location: login.php');
						
						
					} else throw new Exception($connection->error);
					
				}
				
				$connection->close();
			}
		} catch(Exception $e){
			echo 'Server error!';
			echo $e;
		}
		
	} 
?>

<!doctype html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Register</title>
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
											<li> <a href="logout.php" style="color:black">Logout</a></li>
										';
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
                                <h2>Register</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero Area End-->
        <!--================login_part Area =================-->
        <section class="login_part section_padding ">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-md-12">
                        <div class="billing_details">
						  <div class="row">
							<div class="col-lg-8">
							  <h3>Register</h3>
							  <form class="row contact_form" action="#" method="post">
								<div class="col-md-6 form-group ">
								  <input type="text" class="form-control p_star" id="first" name="first" placeholder="First name"/>
									<?php
										if(isset($_SESSION['e_first']))
											echo $_SESSION['e_first'];
									?>
								</div>
								<div class="col-md-6 form-group p_star">
								  <input type="text" class="form-control" id="last" name="last" placeholder="Last name"/>
									<?php
										if(isset($_SESSION['e_last']))
											echo $_SESSION['e_last'];
									?>
								</div>
								<div class="col-md-6 form-group p_star">
								  <input type="password" class="form-control" id="password" name="password" placeholder="Password"/>
									<?php
										if(isset($_SESSION['e_password']))
											echo $_SESSION['e_password'];
									?>
								</div>
								<div class="col-md-6 form-group p_star">
								  <input type="password" class="form-control" id="password" name="passwordc" placeholder="Confirm Password" />
									<?php
										if(isset($_SESSION['e_passwordc']))
											echo $_SESSION['e_passwordc'];
									?>
								</div>
								<div class="col-md-6 form-group p_star">
								  <input type="text" class="form-control" id="number" name="number" placeholder="Phone number"/>
									<?php
										if(isset($_SESSION['e_number']))
											echo $_SESSION['e_number'];
									?>
								</div>
								<div class="col-md-6 form-group p_star">
								  <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" />
									<?php
										if(isset($_SESSION['e_email']))
											echo $_SESSION['e_email'];
									?>
								</div>
								<h3>Biling Details(not mandatory)</h3>
								<div class="col-md-12 form-group">
								  <input type="text" class="form-control" id="country" name="country" placeholder="Country"/>
								  
								</div>
								<div class="col-md-12 form-group">
								  <input type="text" class="form-control" id="add1" name="add1" placeholder="Address line 01"/>
								  
								</div>
								<div class="col-md-12 form-group">
								  <input type="text" class="form-control" id="add2" name="add2" placeholder="Address line 02"/>
								  
								</div>
								<div class="col-md-12 form-group">
								  <input type="text" class="form-control" id="city" name="city" placeholder="Town/City"/>
								  
								</div>
								<div class="col-md-12 form-group">
								  <input type="text" class="form-control" id="district" name="district" placeholder="District"/>

								</div>
								<div class="col-md-12 form-group">
								  <input type="text" class="form-control" id="zip" name="zip" placeholder="Postcode/ZIP" />
								</div>
								<div class="col-md-12 form-group">
									<div class="g-recaptcha" data-sitekey="6Lf88KIZAAAAAOGJe6oELv9CZES-1DgVuRGkANhP"></div>
									<?php
										if(isset($_SESSION['e_bot']))
											echo $_SESSION['e_bot'];
									?>
								</div>
								<div class="col-md-12 form-group">
								<label>
								  <input type="checkbox" name="terms"/>  I accept the terms and conditions
								  </label>
									<?php
										if(isset($_SESSION['e_terms']))
											echo $_SESSION['e_terms'];
									?>
								</div>
								<div class="col-md-12 form-group">
                                
                                        <button type="submit" value="submit" class="btn_3">
                                           Register
                                        </button>
                                        
                                </div>
							  </form>
							</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </section>
        <!--================login_part end =================-->
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
    
    <!-- Scroll up, nice-select, sticky -->
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
	
	 <!-- ReCaptcha -->
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</body>
    
</html>