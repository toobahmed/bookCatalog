<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <link href="style/normalize.css" rel="stylesheet" type="text/css">
        <link href="style/skeleton.css" rel="stylesheet" type="text/css">
        <link href="style/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            function validate() {
                var uname=document.forms['new']['uname'].value;
                var upass=document.forms['new']['upass'].value;
                var name=document.forms['new']['name'].value;
                var email=document.forms['new']['email'].value;
                var city=document.forms['new']['city'].value;
                var gender=document.forms['new']['gender'].value;
                var dob=document.forms['new']['dob'].value;
                if(uname==null || uname=="" || upass==null || upass=="" || name==null || name=="" || email==null || email=="" || city==null || city=="" ) {
                    alert("All fields are necessary. Try again.");
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
                <div id="loginStrip">
                    <a href='index.php'>Login</a>
                </div>
                <a href="index.php">
                    <h1>Online Book Catalog</h1>
                    <h2>More than just a book catalog</h2>
                </a>
            </div>
            <div class="row" id="content">
                <div class="row">
                    <h2>Create Account</h2>
                </div>
                <div class="row">
                    <form name="new" action="user.php" method="post" onsubmit="return validate();" enctype="multipart/form-data">
                        <div class="five columns">
                            <br>
                            <img alt="Profile Picture" src="files/dp.png" width="250px" height="300px">
                            <br>
                            Upload Profile Picture:
                            <br>
                            <input type="file" name="dp">   
                            <br>
                            <label for="gender">Gender:</label>
                            <input type="radio" id="gender" name="gender" value="Male">Male
                            <input type="radio" id="gender" name="gender" value="Female">Female                               
                        </div>
                        <div class="seven columns">
                            <br>
                            <label for="uname">User Name:</label>
                            <input required type="text" id="uname" name="uname">
                            <br>
                            <label for="upass">Password:</label>
                            <input required type="password" id="upass" name="upass">
                            <br>
                            <label for="name">Name:</label>
                            <input required type="text" id="name" name="name">
                            <br>
                            <label for="email">Email:</label>
                            <input required type="email" name="email" id="email">
                            <br>
                            <label for="city">City:</label>
                            <input required type="text" name="city" id="city">
                            <br>
                            <label for="dob">DOB:</label>
                            <input required type="date" name="dob" id="dob" max="<?php echo date('Y-m-d')?>">                                                                      
                            <br>
                            <input type="submit" value="Submit" name="new_user">
                            <input type="reset" value="Clear">
                        </div>
                    </form>
                </div>
            </div>
            <div class="row" id="footer">
                deviant_ideas © 2015
            </div>
        </div>
    </body>
</html>
