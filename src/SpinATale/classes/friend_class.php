<?php

class friend extends config{
    private $fid,$uid1,$uid2,$f_date,$status;
    private $all;
    private $con;
    
    public function friend($uid1){
        $this->con  = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_database);
        if(!$this->con) {
            die("<h1>Database Error</h1><h3>".mysqli_error($this->con)."</h3>");
        }
        $this->uid1=$uid1;
    }
    public function old_friend($fid){
        $this->fid       = $fid;
        $sql	= "SELECT * FROM friend WHERE fid='$this->fid' AND uid1='$this->uid1'";
        $sqlID	= mysqli_query($this->con,$sql);
        if($sqlID){
            $row    = mysqli_fetch_array($sqlID);
            
            $this->uid2     = $row['uid2'];
            $this->f_date   = $row['f_date'];
            $this->status   = $row['status'];
            
            return true;
        }
        else{
            return false; 
        }
    }
    public function new_friend($uid2){
        
        $this->uid2     = mysqli_real_escape_string($this->con,$uid2);
        $this->f_date   = time();
        $this->status   = "request";
    }
     
    public function send(){
        if(!$this->isFriend($this->uid2)){
            $sql        = "INSERT INTO friend(uid1,uid2,status,f_date) VALUES('$this->uid1','$this->uid2','$this->status','$this->f_date')";
            $sqlID      = mysqli_query($this->con,$sql);
            if($sqlID)
                return true;            
        }
        return false;        
    }
    public function accept(){
        $this->f_date=time();
        $sql        = "UPDATE friend SET f_date='$this->f_date',status='accepted' WHERE fid='$this->fid'";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID){
            return true;
        }
        else {
            return false;
        }
    }
    public function delete(){
        $sql        = "DELETE FROM friend WHERE fid='$this->fid'";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID){
            return true;
        }
        else {
            return false;
        }
    }
    public function isFriend($uid1,$uid2){
        $sql	= "SELECT * FROM friend WHERE status='accepted' AND ((uid1='$uid1' AND uid2='$uid2') OR (uid2='$uid1' AND uid1='$uid2'))";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            $row    = mysqli_fetch_array($sqlID);
            $this->old_friend($row['fid']);
            return true;
        }
        else{
            return false;
        }
    }
    public function isRequest($uid1,$uid2){
        $sql	= "SELECT * FROM friend WHERE uid2='$uid1' AND uid1='$uid2' AND status='request'";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            $row    = mysqli_fetch_array($sqlID);
            $this->old_friend($row['fid']);
            return true;
        }
        else{
            return false;
        }
    }
    public function isSentRequest($uid1,$uid2){
        $sql	= "SELECT * FROM friend WHERE uid1='$uid1' AND uid2='$uid2' AND status='request'";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            $row    = mysqli_fetch_array($sqlID);
            $this->old_friend($row['fid']);
            return true;
        }
        else{
            return false;
        }
    }
    public function isAccepted($fid){
        $sql	= "SELECT * FROM friend WHERE fid='$fid' AND status='accepted'";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            $row    = mysqli_fetch_array($sqlID);
            $this->old_friend($row['fid']);
            return true;
        }
        else{
            return false;
        }
    }
    public function selectall($category){
        if($category==="request"){
            $sql	= "SELECT * FROM friend WHERE uid2='$this->uid1' AND status='request'";            
        }
        else if($category==="sent"){
            $sql	= "SELECT * FROM friend WHERE uid1='$this->uid1' AND status='request'";
        }
        else if($category==="friends"){
            $sql	= "SELECT * FROM friend WHERE (uid1='$this->uid1' OR uid2='$this->uid1') AND status='accepted'";
        }
        else{
            $sql	= "SELECT * FROM friend WHERE (uid1='$this->uid1' OR uid2='$this->uid1')";
        }
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            $this->all=$sqlID;
        }
        return mysqli_num_rows($sqlID);
    }
    public function requests(){
        $sql	= "SELECT * FROM friend WHERE uid2='$this->uid1' AND status='request'";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            $this->all=$sqlID;
        }
        return mysqli_num_rows($sqlID);
    }
    
    public function next(){
        if($row    = mysqli_fetch_array($this->all)){
            $this->fid      = $row['fid'];
            $this->uid1      = $row['uid1'];
            $this->uid2      = $row['uid2'];
            $this->f_date    = $row['f_date'];
            $this->status    = $row['status'];
            return true;
        }
        else{
            return false; 
        }
    }
    public function getfid(){
        return $this->fid;
    }
    public function getuid1(){
        return $this->uid1;
    }
    public function getuid2(){
        return $this->uid2;
    }
    public function getf_date(){
        return $this->f_date;
    }
    public function getstatus(){
        return $this->status;
    }
    public function report(){
        return mysqli_error($this->con);
    }
}

?>