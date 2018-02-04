<?php
    include("inc/config_class.php");
    include("inc/header.php");
    include("classes/user_class.php");
    if(isLoggedIn()){
         echo "<script>location.href='home.php';</script>";
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Online Book Catalog</title>
        <link href="style/normalize.css" rel="stylesheet" type="text/css">
        <link href="style/skeleton.css" rel="stylesheet" type="text/css">
        <link href="style/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            function validate() {
                var uname=document.forms['login']['uname'].value;
                var upass=document.forms['login']['upass'].value;
                if(uname==null || uname=="" || upass==null || upass=="") {
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
        <div class="container">
            <div class="row" id="header">
                <div class="row" id="loginStrip">
                    <a href='register_user.php'>Register</a>
                </div>
                <a href="index.php">
                    <h1>Online Book Catalog</h1>
                    <h2>More than just a book catalog</h2>
                </a>
            </div>
            <div id="content">                        
                <div class="row">                            
                    <div class="six columns">
                        <h3>About Us</h3>
                        <p>Keep track of your books!
                        <br>Meet new people!
                        <br>Publish your own Stories!
                        </p>
                    </div>
                    <div class="six columns">
                        <h3>Login</h3>
                        <?php
                        if(isset($_GET['action']) && $_GET['action']=="error"){
                            echo "<br>Incorrect Username and Password!<br>";
                        }
                        ?>
                        <form action="login.php" method="post" name="login" onsubmit="return validate();">        
                            <br>
                            <label for="uname">User Name:</label>
                            <input type="text" id="uname" name="uname">
                            <br>
                            <label for="upass">Password:</label>
                            <input type="password" id="upass" name="upass">
                            <br>
                            <input type="submit" value="Submit" name="user_login">
                            <input type="reset" value="Clear">                                    
                        </form>
                    </div>
                </div>
            </div>
            <div class="row" id="footer">
                deviant_ideas © 2015
            </div>
        </div>
    </body>
</html>
