<?php
	session_start();
	
	//header('Location: ' . $_SERVER['HTTP_REFERER']);
	//!empty($_SESSION["shopping_cart"]);
	
	foreach($_SESSION as $key => $val)
	{

		if ($key != 'shopping_cart') unset($_SESSION[$key]);
	

	}
	
	//session_unset();
	
	header('Location: index.php');
	
	
?>