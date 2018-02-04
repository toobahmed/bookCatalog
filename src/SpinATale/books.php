<?php
    include("inc/config_class.php");
    include("inc/header.php");
    include("classes/user_class.php");
    include("classes/user_book_class.php");
    include("classes/book_class.php");
    authenticate();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1">
        <title>My Books</title>
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
                        echo "Book entry deleted.";
                    }
                    else if(isset($_GET['action']) && $_GET['action']=="updated"){
                            echo "Book updated!";
                    }
                    if(isset($_POST['filter_book'])){
                        $category=$_POST['category'];
                    }
                    else{
                        $category="all";
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="three columns">
                        <form name="filter" method="post" action="books.php">
                            <label name="category" for="category">Shelf: </label>
                            <br>
                            <select name="category" id="category">
                                <option value="all">-Select-</option>
                                <option value="to-read" <?php if($category=='to-read'){echo 'selected';}?> >To Read</option>
                                <option value="reading" <?php if($category=='reading'){echo 'selected';}?> >Reading</option>
                                <option value="read" <?php if($category=='read'){echo 'selected';}?> >Read</option>  
                            </select>
                            <br>
                            <input type="submit" name="filter_book" value="Filter">
                        </form>
                    </div>
                    <div class="nine columns">
                        <?php
                            if(isset($_SESSION["uid"])){
                                $uid = $_SESSION["uid"];
                                $u  = new user();
                                $u->old_user($uid);
                                $ub = new user_book($u->getuid());
                                if($ub->selectall($category)!=0){
                        ?>
                        <br>
                        <table border="0">
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Date Added</th>
                                <th>Status</th>
                                <th colspan="2">Action</th>
                            </tr>
                            <?php
                                while($ub->next()){
                                    $b = new book();
                                    $b->old_book($ub->getbid());
                            ?>
                            <tr><td><a href="view_book.php?bid=<?php echo $b->getbid(); ?>"><?php echo $b->gettitle(); ?></a></td>
                                <td><?php echo $b->getauthor(); ?></td>
                                <td><?php echo @date('Y-m-d h:i:s',$ub->geta_date()); ?></td>
                                <td><?php echo $ub->getcategory(); ?></td>
                                <td>
                                <form name="update_book" action="add.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $ub->getid(); ?>">
                                    <select name="category">
                                        <option value="to-read" <?php if($ub->getcategory()=='to-read'){echo 'selected';}?> >To Read</option>
                                        <option value="reading" <?php if($ub->getcategory()=='reading'){echo 'selected';}?> >Reading</option>
                                        <option value="read" <?php if($ub->getcategory()=='read'){echo 'selected';}?> >Read</option>
                                    </select>
                                    <input type="submit" value="Update" name="update_book">
                                </form>
                                </td>
                                <td><form name="del_ubook" action="delete.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $ub->getid(); ?>">
                                        <input type="submit" value="Remove" name="del_ubook">
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
                                    echo "No Books in <b>".$category."</b> shelf.";
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