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
    
    if(isset($_POST['add_book'])){
        $ub = new user_book($_SESSION['uid']);
        $ub->new_user_book($_POST);
        if($ub->insert()){
            echo "<script>history.go(-1);</script>?action=added";
        }
        else{
            echo "<div class='error'>ERROR : ".$ub->report()."</div>";
        }
    }
    if(isset($_POST['update_book'])){
        $ub = new user_book($_SESSION['uid']);
        $ub->old_user_book($_POST['id']);
        if($ub->update($_POST['category'])){
            echo "<script>history.go(-1);</script>?action=updated";
        }
        else{
            echo "<div class='error'>ERROR : ".$ub->report()."</div>";
        }
    }
    else if(isset($_POST['add_user'])){
        $f = new friend($_SESSION['uid']);
        $f->new_friend($_POST['uid2']);
        if($f->send()){
            echo "<script>history.go(-1);</script>?action=added";
        }
        else{
            echo "<div class='error'>ERROR : ".$f->report()."</div>";
        }
    }
    else if(isset($_POST['accept_friend'])){
        $f = new friend($_SESSION['uid']);
        $f->old_friend($_POST['fid']);
        if($f->accept()){
            echo "<script>history.go(-1);</script>?action=accept";
        }
        else{
            echo "<div class='error'>ERROR : ".$f->report()."</div>";
        }
    }
    else if(isset($_POST['send_msg'])){
        $m = new message($_SESSION['uid']);
        $m->new_message($_POST);
        if($m->send()){
            echo "<script>history.go(-1);</script>?action=sent";
        }
        else{
            echo "<div class='error'>ERROR : ".$m->report()."</div>";
        }
    }
    else if(isset($_POST['read_msg'])){
        $m = new message($_SESSION['uid']);
        $m->old_message($_POST['mid']);
        if($m->update()){
            echo "<script>history.go(-1);</script>?action=read";
        }
        else{
            echo "<div class='error'>ERROR : ".$m->report()."</div>";
        }
    }
    else if(isset($_POST['post_review'])){
        $r  = new review();
        $r->new_review($_POST);
        if($r->post()){
            echo "<script>history.go(-1);</script>?action=r_posted";
        }
        else {
            echo "<div class='error'>ERROR : ".$r->report()."</div>";
        }
    }    
    
?>