<?php
    include("inc/config_class.php");
    include("classes/book_class.php");
    include("inc/header.php");    
    authenticate();
    
    if(isset($_GET['bid'])){
        $b  = new book();
        $b->old_book($_GET['bid']);
        if($b->delete()){
            echo "<script>location.href='dashboard.php?action=delete';</script>";
        }
        else {
            echo "<div class='error'>ERROR : ".$b->report()."</div>";
        }
    }
    
?>