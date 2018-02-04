<?php
    include("inc/config_class.php");
    include("inc/header.php");
    include("classes/user_class.php");
    authenticate();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1">
        <title>Profile</title>
        <link href="style/normalize.css" rel="stylesheet" type="text/css">
        <link href="style/skeleton.css" rel="stylesheet" type="text/css">
        <link href="style/style.css" rel="stylesheet" type="text/css">
            
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
            <div id="content">
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
                    <?php
                        if(isset($_SESSION["uid"])){
                            $uid = $_SESSION["uid"];
                            $u  = new user();
                            $u->old_user($uid);
                    ?>
                    <div class="six columns">
                        <img alt="Profile Picture" src="<?php if($u->getdp()!=null){echo $u->getdp();}else{echo 'files/dp.png';}?>" width="300px">
                        <br>
                        <button name="edit_profile" onclick="location='edit_profile.php'">Edit Profile</button>
                    </div>
                    <div class="six columns">
                        <br>
                        <table border="0">
                            <tr><td>Name:</td>
                                <td><?php echo $u->getname(); ?></td>
                            </tr>
                            <tr><td>Gender:</td>
                                <td><?php echo $u->getgender(); ?></td>
                            </tr>
                            <tr><td>Email:</td>
                                <td><?php echo $u->getemail(); ?></td>
                            </tr>
                            <tr><td>City:</td>
                                <td><?php echo $u->getcity(); ?></td>
                            </tr>
                            <tr><td>Dob:</td>
                                <td><?php echo $u->getdob(); ?></td>
                            </tr>
                        </table>
                        <?php
                        }
                        else{
                            echo "Something wrong with session here!";
                        }
                    ?>
                    </div>
                </div>
            </div>
            <div class="row" id="footer">
                deviant_ideas © 2015
            </div>
        </div>
    </body>
</html>