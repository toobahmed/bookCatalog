<?php
    include("inc/config_class.php");
    include("classes/book_class.php");
    include("inc/header.php");
    authenticate();
?>
<html>
    <head>
        <title>New Book</title>
        <link href="style/style.css" rel="stylesheet" type="text/css">
        <link href="style/normalize.css" rel="stylesheet" type="text/css">
        <link href="style/skeleton.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            function validate() {
                var title=document.forms['new']['title'].value;
                var author=document.forms['new']['author'].value;
                var des=document.forms['new']['des'].value;
                var r_date=document.forms['new']['r_date'].value;
                if(title==null || title=="" || content==null || content=="" || des==null || des=="" || r_date==null || r_date=="") {
                    alert("All fields are necessary. Try again.");
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
            <div id="content">
                <div class="row">
                    <ul id="nav">
                        <li><a href="dashboard.php">Back</a></li>
                    </ul>
                    <?php
                        if(isset($_POST['save'])){
                            $b  = new book();
                            $b->new_book($_POST);
                            if($b->insert()){
                                echo "<script>location.href='dashboard.php?action=new';</script>";
                            }
                            else {
                                echo "<div class='error'>ERROR: ".$b->report()."</div>";
                            }   
                        }                 
                        else{
                    ?>
                    <form name="new" action="new_book.php" method="post" onsubmit="return validate();">
                        <h2>New Book</h2>
                        <div class="row">
                        <div class="three columns">
                            <br>
                            <img alt="Cover" src="files/cover.png" width="200px">
                            <br>
                            Upload Cover:
                            <br>
                            <input type="file" name="cover">
                        </div>
                        <div class="nine columns">
                        <br>
                        <label for="title">Title: </label>
                        <input type="text" name="title" id="title">
                        <br>
                        <label for="author">Author: </label>
                        <input type="text" name="author" id="author">
                        <br>
                        <label for="r_date">Release Date:</label>
                        <input type="date" name="r_date" id="r_date">
                        <br>
                        <label for="des">Description: </label>
                        <textarea name="des" id="des"></textarea>
                        <br>
                        <input type="submit" name="save" value="Save">
                        <input type="reset" name="clear" value="Clear">
                        </div>
                        </div>
                    </form>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>