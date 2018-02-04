<!DOCTYPE html>
<html>
	<head>
		<title>Spin A Tale</title>
		<link href="style/normalize.css" rel="stylesheet" type="text/css">
		<link href="style/skeleton.css" rel="stylesheet" type="text/css">
		<link href="style/style.css" rel="stylesheet" type="text/css">
                <script type="text/javascript">
			function validate() {
				var auname=document.forms['login']['auname'].value;
				var apass=document.forms['login']['apass'].value;
				if(auname==null || auname=="" || apass==null || apass=="") {
				    alert("Both fields are necessary. Try again.");
				    return false;
				}
				else {
				    return true;
				}
			}
		</script>
	</head>
	<body>
		<div class='container'>
			<div class="row">
				<?php
				if(isset($_GET['action']) && $_GET['action']=="error"){
				    echo "Incorrect Username and Password!";
				}
				?>
				<div id="loginbox">
					<form action="login.php" method="post" name="login" onsubmit="return validate();">
						<h2>Welcome</h2>
						<input type="text" id="auname" name="auname" placeholder="Username">
						<input type="password" id="apass" name="apass" placeholder="Password">
						<input type="submit" value="Login" name="admin_login">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
