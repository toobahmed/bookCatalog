<?php
    include("inc/config_class.php");
    include("classes/book_class.php");
    include("classes/review_class.php");
    include("inc/header.php");
    authenticate();
?>
<html>
    <head>
        <title>Moderate Reviews</title>
        <link href="style/style.css" rel="stylesheet" type="text/css">
        <link href="style/normalize.css" rel="stylesheet" type="text/css">
        <link href="style/skeleton.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
            <div id="content">
                <div class="row">
                    <ul id="nav">
                        <li><a href='dashboard.php'>Dashboard</a></li>
                        <li><a href='login.php?logout=true'>Logout</a></li>
                    </ul>
                </div>
                <div class="row">
                    <h2 class="text-center">Moderate Reviews</h2>
                    <form action="mod_reviews.php" method="post">
                        <input type="text" name="bkey" placeholder="Search Book">
                        <input type="submit" name="search" value="Search">
                    </form>
                </div>
                <div class="row">
                    <?php
                        if(isset($_GET['action'])) {
                            if($_GET['action']==="delete"){
                                echo "<div class='success'>Review successfully deleted</div>";
                            }
                        }
                        echo "<br>";
                        $b  = new book();
                        $search="all";
                        if(isset($_POST['search'])){
                            $search=$_POST['bkey'];
                        }
                        if($b->selectall($search)){
                            while($b->next()){
                                echo "
                                <div class='row'>
                                <i>".$b->getauthor()."</i> <b>".$b->gettitle()."</b><br>";
                                $r = new review();
                                if($r->selectall($b->getbid())){
                                echo "
                                <table border='0' class='tbl' cellspacing='0' cellpadding='0'>
                                    <tr>
                                        <th>Date Submitted</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>";
                                while($r->next()){
                                    echo "
                                        <tr>
                                            <td>".@date('Y-m-d h:i:s',$r->gets_date())."</td>
                                            <td>".$r->getdes()."</td>
                                            <td class='text-center'><a href='del_review.php?rid=".$r->getrid()."'>Delete</a></td>
                                        </tr>";
                                    }
                                    echo "</table>";
                                }
                                else{
                                    echo "No Reviews Found";
                                }
                                echo "</div>";
                            }
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