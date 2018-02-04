<?php
    include("inc/header.php");
    include("inc/config_class.php");
    include("classes/user_class.php");
    include("classes/user_book_class.php");
    include("classes/message_class.php");
    include("classes/friend_class.php");
    authenticate();    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1">
        <title>Home</title>
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
                            $uid=$_SESSION["uid"];
                            
                            $u  = new user();
                            $u->old_user($uid);
                            
                            $ub = new user_book($uid);
                            
                            $f = new friend($uid);
                            
                            $m = new message($uid);
                    ?>
                    <div class="seven columns">
                        <div class="row">
                            <br>
                            Books: <b><?php echo $ub->selectall("unread"); ?></b> Unread Books
                        </div>
                    <hr>
                        <div class="row">
                            Messages: <b><?php echo $m->selectall("unread","recieved"); ?></b> Unread Messages
                        </div>
                    <hr>
                        <div class="row">
                            Friends: <b><?php echo $f->requests(); ?></b> Friend requests
                        </div>
                    </div>
                    <div class="five columns">
                        <img alt="Profile Picture" src="<?php if($u->getdp()!=null){echo $u->getdp();}else{echo 'files/dp.png';}?>" width="300px">
                        <br>
                        <b><?php echo $u->getname(); ?></b>
                    </div>
                    <?php
                        }
                        else{
                            echo "<div class='error'>ERROR: ".$u->report()."</div>";
                        }
                    ?>
                </div> 
            </div>
            <div class="row" id="footer">
                deviant_ideas © 2015
            </div>
        </div>
    </body>
</html>