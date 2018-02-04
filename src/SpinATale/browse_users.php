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
        <title>Browse Users</title>
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
                        <li><a href="browse_books.php?books">Browse Books</a>
                    </ul>
                </div>
                <div class="row">
                    <form action="browse_users.php" method="post">
                        <input type="text" name="ukey" placeholder="Search User">
                        <input type="submit" name="search" value="Search">
                    </form>
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
                        $u  = new user();
                        $search="all";
                        if(isset($_POST['search'])){
                            $search=$_POST['ukey'];
                        }
                        if($u->selectall($search)){
                    ?>
                        <table border='0' class='tbl' cellspacing='0' cellpadding='0'>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            while($u->next()){
                                if($u->getuid()==$_SESSION['uid']){
                                    continue;
                                }
                            ?>
                            <tr>
                            <td><img src="<?php if($u->getdp()!=null){echo $u->getdp();}else{echo 'files/dp.png';}?>" alt="Profile Picture" width="60" height="75"></td>
                            <td><a href="view_user.php?uid=<?php echo $u->getuid(); ?>"><?php echo $u->getname(); ?></a></td>
                            <td><?php echo $u->getcity(); ?></td>
                            <td>
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
                            </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </table>
                        <?php
                            }
                            else{
                                echo "No users here";
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