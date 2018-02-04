<?php
    include("inc/config_class.php");
    include("classes/book_class.php");
    include("inc/header.php");
    authenticate();
?>
<html>
    <head>
        <title>Edit Book</title>
        <link href="style/style.css" rel="stylesheet" type="text/css">
        <link href="style/normalize.css" rel="stylesheet" type="text/css">
        <link href="style/skeleton.css" rel="stylesheet" type="text/css">
        <script type="text/javascript">
            function validate() {
                var title=document.forms['edit']['title'].value;
                var author=document.forms['edit']['author'].value;
                var des=document.forms['edit']['des'].value;
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
                        if(isset($_GET['bid'])){
                            $b  = new book();
                            $b->old_book($_GET['bid']);
                            if(isset($_POST['save'])){
                                if($b->update($_POST)){
                                    echo "<script>location.href='dashboard.php?action=update';</script>";
                                }
                                else {
                                    echo "<div class='error'>ERROR: ".$b->report()."</div>";
                                }   
                            }                 
                            else{
                    ?>
                    <form name="edit" action="edit_book.php?bid=<?php echo $b->getbid(); ?>" method="post" onsubmit="return validate();" enctype="multipart/form-data">
                        <h2>Edit Book</h2>
                        <div class="row">
                        <div class="three columns">
                            <br>
                            <img alt="Cover" src="<?php if($b->getcover()!=null){echo $b->getcover();}else{echo 'files/cover.png';}?>" width="200px">
                            <br>
                            Upload Cover:
                            <br>
                            <input type="file" name="cover">
                        </div>
                        <div class="nine columns">
                        
                            <br>
                            <label for="title">Title: </label>
                            <input type="text" name="title" id="title" value="<?php echo $b->gettitle(); ?>">
                            <br>
                            <label for="author">Author: </label>
                            <input type="text" name="author" id="author" value="<?php echo $b->getauthor(); ?>">
                            <br>
                            <label for="rdate">Release Date:</label>
                            <input type="date" name="r_date" id="rdate" value="<?php echo $b->getr_date(); ?>">
                            <br>
                            <label for="des">Description: </label>
                            <textarea name="des" id="des"> <?php echo $b->getdes(); ?></textarea>
                            <br>
                            <input type="submit" name="save" value="Update">
                        </div>
                        </div>
                    </form>
                    <?php
                            }
                        }
                        else{
                            echo "<div class='error'>ERROR: ".$b->report()."</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>