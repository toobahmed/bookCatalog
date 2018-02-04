<?php
    include("inc/header.php");
    include("inc/config_class.php");
    include("classes/user_class.php");
    include("classes/book_class.php");
    include("classes/user_book_class.php");
    include("classes/message_class.php");
    include("classes/friend_class.php");
    include("classes/review_class.php");
    authenticate();
    
    if(isset($_POST['del_ubook'])){
        $ub = new user_book($_SESSION['uid']);
        $ub->old_user_book($_POST['id']);
        if($ub->delete()){
            echo "<script>history.go(-1);</script>?action=delete";
        }
        else{
            echo "<div class='error'>ERROR : ".$ub->report()."</div>";
        }
    }
    else if(isset($_POST['del_friend'])){
        $f = new friend($_SESSION['uid']);
        $f->old_friend($_POST['fid']);
        if($f->delete()){
            echo "<script>history.go(-1);</script>?action=delete";
        }
        else{
            echo "<div class='error'>ERROR : ".$f->report()."</div>";
        }
    }
    else if(isset($_POST['del_msg'])){
        $m = new message($_SESSION['uid']);
        $m->old_message($_POST['mid']);
        if($m->delete()){
            echo "<script>history.go(-1);</script>?action=delete";
        }
        else{
            echo "<div class='error'>ERROR : ".$m->report()."</div>";
        }
    }
    else if(isset($_POST['del_review'])){
        $r  = new review();
        $r->old_review($_POST['rid']);
        if($r->delete()){
            echo "<script>history.go(-1);</script>";
        }
        else {
            echo "<div class='error'>ERROR : ".$r->report()."</div>";
        }
    }
    
?>