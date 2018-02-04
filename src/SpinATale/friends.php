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
        <title>Friends</title>
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
                    if(isset($_GET['action']) && $_GET['action']=="delete"){
                        echo "Friend removed.";
                    }
                    if(isset($_GET['action']) && $_GET['action']=="added"){
                        echo "Friend request accepted!";
                    }
                    if(isset($_POST['filter_friends'])){
                        $category=$_POST['category'];
                    }
                    else{
                        $category="";
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="three columns">
                        <form name="filter" method="post" action="friends.php">
                            <label name="category" for="category">Friends: </label>
                            <br>
                            <select name="category" id="category">
                                <option value="">-Select-</option>
                                <option value="friends" <?php if($category=='friends'){echo 'selected';}?> >Accepted</option>
                                <option value="sent" <?php if($category=='sent'){echo 'selected';}?>>Sent Requests</option>
                                <option value="request" <?php if($category=='request'){echo 'selected';}?> >Requests</option>
                            </select>
                            <br>
                            <input type="submit" name="filter_friends" value="Filter">
                        </form>
                    </div>
                    <div class="nine columns">
                        <?php
                            if(isset($_SESSION["uid"])){
                                $uid = $_SESSION["uid"];
                                $u  = new user();
                                $u->old_user($uid);
                                $f = new friend($u->getuid());
                                if($f->selectall($category)!=0){
                        ?>
                        <br>
                        <table border="0">
                            <tr>
                                <th>Name</th>
                                <th>Date Added</th>
                                <th>Status</th>
                                <th colspan="2">Action</th>
                            </tr>
                            <?php
                                while($f->next()){
                                    $u = new user();
                                    if($f->getuid1()==$_SESSION['uid']){
                                        $u->old_user($f->getuid2());
                                    }else{
                                        $u->old_user($f->getuid1());
                                    }
                            ?>
                            <tr><td><a href="view_user.php?uid=<?php echo $u->getuid(); ?>"><?php echo $u->getname(); ?></a></td>
                                <td><?php echo @date('Y-m-d h:i:s',$f->getf_date()); ?></td>
                                <td><?php echo $f->getstatus(); ?></td>
                                <td>
                                    <?php
                                    if(!($f->isAccepted($f->getfid()))){
                                    ?>
                                    <form name="accept_friend" action="add.php" method="post">
                                        <input type="hidden" name="fid" value="<?php echo $f->getfid(); ?>">
                                        <input type="submit" value="Accept Request" name="accept_friend">
                                    </form>
                                    <?php
                                    }
                                    ?>
                                    <form name="del_friend" action="delete.php" method="post">
                                        <input type="hidden" name="fid" value="<?php echo $f->getfid(); ?>">
                                        <?php
                                        if($f->isSentRequest($_SESSION['uid'],$u->getuid())){
                                            echo "<input type='submit' value='Cancel Request' name='del_friend'>";
                                        }else if($f->isRequest($_SESSION['uid'],$u->getuid())){
                                            echo "<input type='submit' value='Decline Request' name='del_friend'>";
                                        }else{
                                            echo "<input type='submit' value='Remove Friend' name='del_friend'>";
                                        }
                                        ?>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </table>
                        <?php
                                }
                                else{
                                    echo "Nothing in <b>".$category."</b> category.";
                                }
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