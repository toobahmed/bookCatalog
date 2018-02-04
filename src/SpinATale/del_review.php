<?php
    include("inc/config_class.php");
    include("classes/review_class.php");
    include("inc/header.php");    
    authenticate();
    
    if(isset($_GET['rid'])){
        $r  = new review();
        $r->old_review($_GET['rid']);
        if($r->delete()){
            echo "<script>location.href='mod_reviews.php?action=delete';</script>";
        }
        else {
            echo "<div class='error'>ERROR : ".$r->report()."</div>";
        }
    }
    
?>