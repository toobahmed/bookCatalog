<?php
    include("inc/config_class.php");
    include("inc/header.php");
    include("classes/user_class.php");
    include("classes/book_class.php");
    include("classes/user_book_class.php");
    authenticate();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1">
        <title>Browse Books</title>
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
                    <form action="browse_books.php" method="post">
                        <input type="text" name="bkey" placeholder="Search Book">
                        <input type="submit" name="search" value="Search">
                    </form>
                </div>
                <div class="row">
                    <?php
                        if(isset($_GET['action']) && $_GET['action']=="added"){
                            echo "Book added!";
                        }
                        
                        $b  = new book();
                        $search="all";
                        if(isset($_POST['search'])){
                            $search=$_POST['bkey'];
                            }
                        if($b->selectall($search)){
                    ?>
                        <table border='0' class='tbl' cellspacing='0' cellpadding='0' class="text-center">
                            <tr>
                                <th>Cover</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            while($b->next()){
                            ?>
                            <tr>
                            <td><img src="<?php if($b->getcover()!=null){echo $b->getcover();}else{echo 'files/cover.png';}?>" alt="Cover" width="100" height="100"></td>
                            <td><a href="view_book.php?bid=<?php echo $b->getbid(); ?>"><?php echo $b->gettitle(); ?></a></td>
                            <td><?php echo $b->getauthor(); ?></td>
                            <td>
                                <?php
                                    $ub = new user_book($_SESSION['uid']);
                                    
                                    if(!($ub->exists($b->getbid()))){
                                ?>
                                <form name="add_book" action="add.php" method="post">
                                    <input type="hidden" name="bid" value="<?php echo $b->getbid(); ?>">
                                    <select name="category">
                                        <option value="reading">Reading</option>
                                        <option value="to-read">To Read</option>
                                        <option value="read">Read</option>
                                    </select>
                                    <input type="submit" value="Add" name="add_book">
                                </form>
                                <?php
                                    }
                                    else{
                                ?>
                                <form name="del_ubook" action="delete.php" method="post">
                                    <input type="hidden" name="id" value="<?php echo $ub->getid(); ?>">
                                    <input type="submit" value="Remove" name="del_ubook">
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
                                echo "No books";
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