<?php
    include("inc/config_class.php");
    include("inc/header.php");
    include("classes/user_class.php");


    if(isset($_POST['new_user'])) {
        $u  = new user();
        $u->new_user($_POST);
        if($u->insert()){
            echo "<script>location.href='index.php';</script>";
        }
        else {
            echo "<div class='error'>ERROR : Unfortunately this username exists, try another. ".$u->report()."</div>";
        }
    }
    
    else if(isset($_POST['edit_user'])) {
        
        $uid= $_SESSION['uid'];        
        $u  = new user();
        $u->old_user($uid);
        
        if($u->update($_POST)){
            echo "<script>location.href='profile.php';</script>";
        }
        else {
            echo "<div class='error'>ERROR : ".$u->report()."</div>";
        }
    }
    
    else if(isset($_POST['delete_user'])) {
        
        $uid=$_SESSION['uid'];        
        $u  = new user();
        $u->old_user($uid);
        
        if($u->delete()){
            echo "<script>location.href='login.php?logout=true';</script>";
        }
        else {
            echo "<div class='error'>ERROR : ".$u->report()."</div>";
        }
    }
    
    else{
        echo "<script>location.href='index.php';</script>";
    }
    ?>
