<?php
    include("inc/config_class.php");
    include("inc/header.php");
    include("classes/user_class.php");
    authenticate();
    if(isset($_SESSION["uid"])){
        $uid = $_SESSION["uid"];
        $u  = new user();
        $u->old_user($uid);
    }
    else{
        echo "Something wrong with session here!";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit Profile</title>
        <link href="style/normalize.css" rel="stylesheet" type="text/css">
        <link href="style/skeleton.css" rel="stylesheet" type="text/css">
        <link href="style/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            function validate() {
                var upass=document.forms['edit']['upass'].value;
                var name=document.forms['edit']['name'].value;
                var email=document.forms['edit']['email'].value;
                var city=document.forms['edit']['city'].value;
                var gender=document.forms['edit']['gender'].value;
                var dob=document.forms['edit']['dob'].value;
                if(upass==null || upass=="" || name==null || name=="" || email==null || email=="" || city==null || city=="") {
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
                    <a href='login.php?logout=true'>Logout</a>
                </div>
                <a href="home.php">
                    <h1>Online Book Catalog</h1>
                    <h2>More than just a book catalog</h2>
                </a>
            </div>
            <div class="row" id="content">
                <div class="row">
                    <ul id="nav">
                        <li><a href="home.php">Home</a>
                        <li><a href="profile.php">Profile</a>
                        <li><a href="books.php">My Books</a>
                        <li><a href="friends.php">Friends</a>
                        <li><a href="messages.php">Messages</a>
                        <li><a href="browse_users.php">Browse Users</a>
                        <li><a href="browse_books.php">Browse Books</a>
                    </ul>
                </div>
                <div class="row">
                    <h2>Edit Profile</h2>
                </div>
                <div class="row">
                    <form name="edit" action="user.php" method="post" onsubmit="return validate();" enctype="multipart/form-data">
                        <div class="five columns">
                            <br>
                            <img alt="Profile Picture" src="<?php if($u->getdp()!=null){echo $u->getdp();}else{echo 'files/dp.png';}?>" width="300px">
                            <br>
                            Upload Profile Picture:
                            <br>
                            <input type="file" name="dp">                                
                            <br>
                            <label for="gender">Gender:</label>
                            <input type="radio" id="gender" name="gender" value="Male" <?php if($u->getgender()=='Male')echo 'checked'?>>Male
                            <input type="radio" id="gender" name="gender" value="Female" <?php if($u->getgender()=='Female')echo 'checked'?>>Female                           
                        </div>
                        <div class="seven columns">
                            <br>
                            <input required type="hidden" id="uname" name="uname" value="<?php echo $u->getuname(); ?>">
                            <label for="upass">Password:</label>
                            <input required type="password" id="upass" name="upass" value="<?php echo $u->getupass(); ?>">
                            <br>
                            <label for="name">Name:</label>
                            <input required type="text" id="name" name="name" value="<?php echo $u->getname(); ?>">
                            <br>
                            <label for="email">Email:</label>
                            <input required type="email" name="email" id="email" value="<?php echo $u->getemail(); ?>">
                            <br>
                            <label for="city">City:</label>
                            <input required type="text" name="city" id="city" value="<?php echo $u->getcity(); ?>">
                            <br>
                            <label for="dob">DOB:</label>
                            <input required type="date" name="dob" id="dob" max="<?php echo date('Y-m-d')?>" value="<?php echo $u->getdob();?>">                                                                      
                            <br>
                            <input type="submit" value="Submit" name="edit_user">                            
                            <input type="reset" value="Clear">
                            <br>
                            <input type="Submit" name="delete_user" value="Delete Account">
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
