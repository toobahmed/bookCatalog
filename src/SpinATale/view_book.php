<?php
    include("inc/config_class.php");
    include("inc/header.php");
    include("classes/book_class.php");
    include("classes/user_class.php");
    include("classes/user_book_class.php");
    include("classes/review_class.php");
    authenticate();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1">
        <title>View Book</title>
        <link href="style/normalize.css" rel="stylesheet" type="text/css">
        <link href="style/skeleton.css" rel="stylesheet" type="text/css">
        <link href="style/style.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            function validate() {
                var des=document.forms['post_review']['des'].value;
                if(des==null || des=="") {
                    alert("Empty review. Try again.");
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
                <br>
                <div class="row">
                <?php
                    if(isset($_GET['action']) && $_GET['action']=="r_added"){
                            echo "Review posted!";
                    }
                    else if(isset($_GET['action']) && $_GET['action']=="added"){
                            echo "Book added!";
                    }
                    else if(isset($_GET['action']) && $_GET['action']=="delete"){
                        echo "Book entry deleted.";
                    }
                    else if(isset($_GET['action']) && $_GET['action']=="updated"){
                            echo "Book updated!";
                    }
                    if(isset($_GET['bid'])){
                        $uid = $_SESSION["uid"];
                        $b  = new book();
                        if($b->old_book($_GET['bid'])){
                                
                    ?>
                </div>
                <div class="row">
                    <div class="four columns">
                        <img alt="Cover" src="<?php if($b->getcover()!=null){echo $b->getcover();}else{echo 'files/cover.png';}?>" width="150px" height="150px">
                        <?php
                            $ub = new user_book($_SESSION['uid']);
                            
                            if(!($ub->exists($b->getbid()))){
                        ?>
                        <form name="add_book" action="add.php" method="post">
                            <input type="hidden" name="bid" value="<?php echo $b->getbid(); ?>">
                            <select name="category">                            
                                <option value="to-read">To Read</option>
                                <option value="reading">Reading</option>
                                <option value="read">Read</option>
                            </select>    
                            <input type="submit" value="Add" name="add_book">
                        </form>
                        <?php
                            }
                            else{
                        ?>
                        <form name="update_book" action="add.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $ub->getid(); ?>">
                            <select name="category">
                                
                            <option value="to-read" <?php if($ub->getcategory()=='to-read'){echo 'selected';}?> >To Read</option>
                                <option value="reading" <?php if($ub->getcategory()=='reading'){echo 'selected';}?> >Reading</option>
                                <option value="read" <?php if($ub->getcategory()=='read'){echo 'selected';}?> >Read</option>
                            </select>
                            <input type="submit" value="Update" name="update_book">
                        </form>
                        <form name="del_ubook" action="delete.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $ub->getid(); ?>">
                            <input type="submit" value="Remove" name="del_ubook">
                        </form>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="eight columns">
                        <br>
                        <table border="0">
                            <tr><td>Title:</td>
                                <td><?php echo $b->gettitle(); ?></td>
                            </tr>
                            <tr><td>Author:</td>
                                <td><?php echo $b->getauthor(); ?></td>
                            </tr>
                            <tr><td>Release Date:</td>
                                <td><?php echo $b->getr_date(); ?></td>
                            </tr>
                            <tr><td>Description:</td>
                                <td><?php echo $b->getdes(); ?></td>
                            </tr>
                        </table>
                        
                    </div>
                </div>
                <div class="row">
                        <form name="post_review" action="add.php" method="post" onsubmit="return validate();">
                        <input type="hidden" name="bid" value="<?php echo $b->getbid(); ?>">
                        <input type="hidden" name="uid" value="<?php echo $_SESSION['uid']; ?>">
                        <label for="des">Review:</label>
                        <br>
                        <textarea id="des" name="des"></textarea>
                        <input type="submit" name="post_review" value="Post">
                        </form>
                        
                    <h2>Reviews:</h2>
                    <?php
                        $r  = new review();
                        if($r->selectall($b->getbid())){
                            ?>
                            <table border="0">
                                <?php
                                    while($r->next()){
                                        $u  = new user();
                                        
                                ?>
                                <tr>
                                    <td><?php if($u->old_user($r->getuid())){ echo $u->getname();} else{echo "[deleted]";} ?></td>
                                    <td><?php echo $r->getdes(); ?></td>
                                    <td><?php echo @date('Y-m-d h:i:s',$r->gets_date()); ?></td>
                                    <td>
                                        <?php if($r->getuid()==$_SESSION['uid']){
                                        ?>
                                        <form name="del_review" action="delete.php" method="post">
                                            <input type="hidden" name="rid" value="<?php echo $r->getrid(); ?>">
                                            <input type="submit" value="Delete" name="del_review">
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
                            echo "No Reviews";
                        }
                    ?>
                </div>
                <?php
                        }
                        else{
                            echo "No such book exists!";
                        }
                    }
                    else{
                        echo "Something wrong here!";
                    }
                ?>
            </div>
            <div class="row" id="footer">
                deviant_ideas © 2015
            </div>
        </div>
    </body>
</html>