<?php
    include("inc/config_class.php");
    include("inc/header.php");
    include("classes/user_class.php");
    include("classes/friend_class.php");
    authenticate();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1">
        <title>View User</title>
        <link href="style/normalize.css" rel="stylesheet" type="text/css">
        <link href="style/skeleton.css" rel="stylesheet" type="text/css">
        <link href="style/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            function validate() {
                var des=document.forms['send_message']['des'].value;
                if(des==null || des=="") {
                    alert("Empty message. Try again.");
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
                    if(isset($_GET['action']) && $_GET['action']=="added"){
                            echo "Friend request sent!";
                    }
                    else if(isset($_GET['action']) && $_GET['action']=="accept"){
                            echo "Friend request sent!";
                    }
                    else if(isset($_GET['action']) && $_GET['action']=="delete"){
                        echo "Friend removed.";
                    }
                    else if(isset($_GET['action']) && $_GET['action']=="sent"){
                        echo "Message sent!";
                    }
                    
                        if(isset($_GET['uid'])){
                            $uid = $_SESSION["uid"];
                            $u  = new user();
                            if($u->old_user($_GET['uid'])){
                                
                    ?>
                    <div class="four columns">
                        <img alt="Profile Picture" src="<?php if($u->getdp()!=null){echo $u->getdp();}else{echo 'files/dp.png';}?>" width="250px" height="300px">
                    </div>
                    <div class="four columns">
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
                        
                    </div>
                    <div class="four columns">
                        <?php
                            $f = new friend($_SESSION['uid']);                            
                            if($f->isFriend($_SESSION['uid'],$u->getuid())){
                        ?>
                        <form name="del_friend" action="delete.php" method="post">
                            <input type="hidden" name="fid" value="<?php echo $f->getfid(); ?>">
                            <input type="submit" value="Remove Friend" name="del_friend">
                        </form>
                        <?php
                            }
                            else if($f->isRequest($_SESSION['uid'],$u->getuid())){
                        ?>
                        <form name="accept_friend" action="add.php" method="post">
                            <input type="hidden" name="fid" value="<?php echo $f->getfid(); ?>">
                            <input type="submit" value="Accept Request" name="accept_friend">
                        </form>
                        <form name="del_friend" action="delete.php" method="post">
                            <input type="hidden" name="fid" value="<?php echo $f->getfid(); ?>">
                            <input type="submit" value="Decline Request" name="del_friend">
                        </form>
                        <?php
                            }else if($f->isSentRequest($_SESSION['uid'],$u->getuid())){ 
                        ?>
                        <form name="del_friend" action="delete.php" method="post">
                            <input type="hidden" name="fid" value="<?php echo $f->getfid(); ?>">
                            <input type="submit" value="Cancel Request" name="del_friend">
                        </form>
                        <?php
                            }else{
                        ?>
                        <form name="add_user" action="add.php" method="post">
                            <input type="hidden" name="uid2" value="<?php echo $u->getuid(); ?>">
                            <input type="submit" value="Send Friend Request" name="add_user">
                        </form>
                        <?php
                        }
                        ?>
                        <form name="send_msg" action="add.php" method="post" onsubmit="return validate();">
                            <input type="hidden" name="uid2" value="<?php echo $u->getuid(); ?>">
                            <label for="des">Message:</label>
                            <br>
                            <textarea id="des" name="des"></textarea>
                            <input type="submit" name="send_msg" value="Send">
                        </form>
                    </div>
                    <?php
                            }
                            else{
                                echo "No such user exists!";
                            }
                        }
                        else{
                            echo "Something wrong with session here!";
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