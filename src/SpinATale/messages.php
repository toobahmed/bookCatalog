<?php
    include("inc/config_class.php");
    include("inc/header.php");
    include("classes/user_class.php");
    include("classes/friend_class.php");
    include("classes/message_class.php");
    authenticate();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1">
        <title>Messages</title>
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
                        echo "Message deleted.";
                    }
                    else if(isset($_GET['action']) && $_GET['action']=="sent"){
                        echo "Message sent!";
                    }
                    else if(isset($_GET['action']) && $_GET['action']=="read"){
                        echo "Message marked as read!";
                    }
                    if(isset($_POST['filter_messages'])){
                        $category=$_POST['category'];
                        $status=$_POST['status'];
                    }
                    else{
                        $status="all";
                        $category="recieved";
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="three columns">
                        <form name="filter" method="post" action="messages.php">
                            <label name="category" for="category">Messages: </label>
                            <br>
                            <select name="category" id="category">
                                <option value="recieved" <?php if($category=='recieved'){echo 'selected';}?> >Recieved</option>
                                <option value="sent" <?php if($category=='sent'){echo 'selected';}?> >Sent</option>
                            </select>
                            <br>
                            <label name="status" for="status">Status: </label>
                            <br>
                            <select name="status" id="status">
                                <option value="all">-Select-</option>
                                <option value="unread" <?php if($status=='unread'){echo 'selected';}?> >Unread</option>
                                <option value="read" <?php if($status=='read'){echo 'selected';}?> >Read</option>
                            </select>
                            <br>
                            <input type="submit" name="filter_messages" value="Filter">
                        </form>
                    </div>
                    <div class="nine columns">
                        <?php
                            if(isset($_SESSION["uid"])){
                                $m = new message($_SESSION["uid"]);
                                if($m->selectall($status,$category)!=0){
                        ?>
                        <br>
                        <table border="0">
                            <tr>
                                <th><?php if($category=="recieved"){echo "From";}else if($category=="sent"){echo "To";}?></th>
                                <th>Date</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <?php
                                while($m->next()){
                                    
                            ?>
                            <tr><td><?php
                                        $u = new user();
                                        if($category=="recieved"){
                                            $uid=$m->getuid1();
                                        }else{
                                            $uid=$m->getuid2();
                                        }
                                        if($u->old_user($uid)){
                                    ?>
                                        <a href='view_user.php?uid=<?php echo $u->getuid(); ?>'><?php echo $u->getname(); ?></a>
                                    <?php
                                    } else{
                                        echo "[deleted]";
                                    } ?>
                                </td>
                                <td><?php echo @date('Y-m-d h:i:s',$m->getm_date()); ?></td>
                                <td><?php echo $m->getdes(); ?></td>
                                <td><?php echo $m->getstatus(); ?></td>                                
                                <td>
                                    <?php
                                        if($category=="recieved"){
                                            if(!$m->isread()){
                                    ?>
                                    <form name="read_msg" action="add.php" method="post">
                                        <input type="hidden" name="mid" value="<?php echo $m->getmid(); ?>">
                                        <input type="submit" value="Mark as Read" name="read_msg">
                                    </form>
                                    <?php
                                            }
                                            else{
                                    ?>
                                    <form name="del_msg" action="delete.php" method="post">
                                        <input type="hidden" name="mid" value="<?php echo $m->getmid(); ?>">
                                        <input type="submit" value="Delete" name="del_msg">
                                    </form>
                                    <?php
                                            }
                                        }else{
                                    ?>
                                    <form name="del_msg" action="delete.php" method="post">
                                        <input type="hidden" name="mid" value="<?php echo $m->getmid(); ?>">
                                        <input type="submit" value="Delete" name="del_msg">
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
                                    echo "No Messages.";
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