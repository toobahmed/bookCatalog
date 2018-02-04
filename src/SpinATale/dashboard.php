<?php
    include("inc/config_class.php");
    include("classes/book_class.php");
    include("inc/header.php");
    authenticate();
?>
<html>
    <head>
        <title>Dashboard</title>
        <link href="style/style.css" rel="stylesheet" type="text/css">
        <link href="style/normalize.css" rel="stylesheet" type="text/css">
        <link href="style/skeleton.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
            <div id="content">
                <div class="row">
                    <ul id="nav">
                        <li><a href='new_book.php'>New</a></li>
                        <li><a href='mod_reviews.php'>Moderate Reviews</a></li>
                        <li><a href='login.php?logout=true'>Logout</a></li>
                    </ul>
                </div>
                <div class="row">
                    <h2 class="text-center">Manage Books</h2>
                    <form action="dashboard.php" method="post">
                        <input type="text" name="bkey" placeholder="Search Book">
                        <input type="submit" name="search" value="Search">
                    </form>
                </div>
                <div class="row">
                    <?php
                        if(isset($_GET['action'])) {
                            if($_GET['action']==="delete"){
                                echo "<div class='success'>Book successfully deleted</div>";
                            }
                            else if($_GET['action']==="new"){
                                echo "<div class='success'>Book successfully saved</div>";
                            }
                            else if($_GET['action']==="update"){
                                echo "<div class='success'>Book successfully updated</div>";
                            }
                        }
                        echo "<br>";
                        $b  = new book();
                        $search="all";
                        if(isset($_POST['search'])){
                            $search=$_POST['bkey'];
                        }
                        if($b->selectall($search)){
                            echo "
                                <table border='0' class='tbl' cellspacing='0' cellpadding='0'>
                                    <tr>
                                        <th>Cover</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Date Released</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>";
                                while($b->next()){
                                    echo "
                                        <tr>
                                            <td><img src=";
                                            if($b->getcover()!=null){
                                                echo $b->getcover();
                                            }else{
                                                echo 'files/cover.png';
                                            }
                                            echo " alt='Cover' width='100'></td>
                                            <td>".$b->gettitle()."</td>
                                            <td>".$b->getauthor()."</td>
                                            <td class='text-center'>".$b->getr_date()."</td>
                                            <td>".$b->getdes()."</td>
                                            <td class='text-center'><a href='del_book.php?bid=".$b->getbid()."'>Delete</a> / <a href='edit_book.php?bid=".$b->getbid()."'>Edit</a></td>
                                        </tr>";
                                    }
                                echo "</table>";
                        }
                        else{
                            echo "<div class='error'>No Books Found</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>