<?php
	include("inc/config_class.php");
	include("classes/user_class.php");
	include("classes/admin_class.php");
	include("inc/header.php");

	if(isset($_GET["logout"])) {
		unset($_SESSION["login"]);
		session_destroy();
		header("Location:index.php");
	}
	else if(isset($_POST['user_login'])) {
		$u	= new user();
		if($u->login($_POST['uname'],$_POST['upass'])){
			$_SESSION["login"] = true;
			$_SESSION["uid"]=$u->getuid();
			echo "<div class='success'>Login successful. Redirecting to Home<script>location.href='home.php';</script></div>";
		} else {
			echo "<script>history.go(-1);</script>?action=error";
		}
	}
	else if(isset($_POST['admin_login'])){
		$a	= new admin();
		echo $_POST['auname']." ".$_POST['apass'];
		if($a->login($_POST['auname'],$_POST['apass'])){
			$_SESSION["login"] = true;
			$_SESSION["aid"]=$a->getaid();
			echo "<div class='success'>Login successful. Redirecting to Dashboard<script>location.href='dashboard.php';</script></div>";
		} else {
			echo "<script>history.go(-1);</script>?action=error";	
		}
	}
	else {
		echo "<div class='error'>Something wrong!</div>";
	}
?>