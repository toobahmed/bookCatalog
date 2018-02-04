<?php

class user extends config{
    
    private $uid,$uname,$upass,$name,$dp,$email,$city,$gender,$dob,$error;
    private $all;
    private $con;
    
    public function user(){
        
        $this->con  = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_database);
        if(!$this->con) {
            die("<h1>Database Error</h1><h3>".mysqli_error($this->con)."</h3>");
        }
    }
    
    public function old_user($uid){
        $this->uid       = $uid;
        $sql	= "SELECT * FROM user WHERE uid='$this->uid'";
        $sqlID	= mysqli_query($this->con,$sql);
        if($sqlID){
            $row    = mysqli_fetch_array($sqlID);
            
            $this->uname    = $row['uname'];
            $this->upass    = $row['upass'];
            $this->name     = $row['name'];
            $this->dp       = $row['dp'];
            $this->email    = $row['email'];
            $this->city     = $row['city'];
            $this->gender   = $row['gender'];
            $this->dob      = $row['dob'];
            
            return true;
        }
        else{
            return false; 
        }
        
    }
    function validate($_POST){
        foreach($_POST as $input){
            if($input=="" || $input==null){
                return false;
            }
        }
        return true;
    }
    
    public function new_user($_POST){

        $this->uname    = mysqli_real_escape_string($this->con,$_POST['uname']);
        $this->upass    = mysqli_real_escape_string($this->con,$_POST['upass']);
        $this->name     = mysqli_real_escape_string($this->con,$_POST['name']);        
        $this->email    = mysqli_real_escape_string($this->con,$_POST['email']);
        $this->city     = mysqli_real_escape_string($this->con,$_POST['city']);
        $this->gender   = $_POST['gender'];
        $this->dob      = mysqli_real_escape_string($this->con,$_POST['dob']);
        
        if(isset($_FILES) && $_FILES["dp"]["tmp_name"]!=="") {
            /* Process uploaded pic and check for errors */
            $allowedExts = array("jpeg", "jpg", "png");
            $allowedMimes = array("image/jpeg","image/jpg","image/pjpeg","image/x-png","image/png","image/bmp");
            $allowedMaxSize = 2; // in MB
            $hash = md5(time().rand(0,99999));
            $temp = explode(".", $_FILES["dp"]["name"]);
            $pic_extension    = end($temp);
            $pic_filename     = $hash.".".$pic_extension;
            $pic_dir          ="img";
            
            if($_FILES["dp"]["size"] > ($allowedMaxSize*1024*1024)){
                $this->error.="Picture should not be larger than ".$allowedMaxSize."MB";
            }
            if (in_array(strtolower($_FILES["dp"]["type"]),$allowedMimes) && in_array(strtolower($pic_extension),$allowedExts)) {
                if ($_FILES["dp"]["error"] > 0) {
                    $this->error.="An error ocurred in the picture you uploaded";                                             
                } else {                                                
                    if (file_exists($pic_dir."/".$pic_filename)) {                                                    
                    } else {
                        move_uploaded_file($_FILES["dp"]["tmp_name"],$pic_dir."/".$pic_filename);
                        $this->dp = $pic_dir."/".$pic_filename;
                    }
                }
                
            } else {
                $this->error.="Invalid picture";
            }            
        }

    
    }
    
    public function insert(){
        if(!$this->exists()){
            $sql        = "INSERT INTO user(uname,upass,name,email,city,gender,dob,dp) VALUES('$this->uname','$this->upass','$this->name','$this->email','$this->city','$this->gender','$this->dob','$this->dp')";
            $sqlID      = mysqli_query($this->con,$sql);
            if($sqlID)
                return true;            
        }
        return false;        
    }
    
    public function update($_POST){
        $this->new_user($_POST);
        $sql        = "UPDATE user SET uname='$this->uname',upass='$this->upass',name='$this->name',email='$this->email',city='$this->city',gender='$this->gender',dob='$this->dob',dp='$this->dp' WHERE uid='$this->uid'";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID){
            return true;
        }
        else {
            return false;
        }
    }
    public function delete(){
        $sql1        = "DELETE FROM user WHERE uid='$this->uid'";
        $sql2        = "DELETE FROM user_book WHERE uid='$this->uid'";
        $sql3        = "DELETE FROM friend WHERE uid1='$this->uid' OR uid12='$this->uid'";
        $sqlID1      = mysqli_query($this->con,$sql1);
        $sqlID2      = mysqli_query($this->con,$sql2);
        $sqlID3      = mysqli_query($this->con,$sql3);
        if($sqlID1 && $sqlID2 && $sqlID3){
            return true;
        }
        else {
            return false;
        }
    }
    public function exists(){
        $sql	= "SELECT * FROM user WHERE uname='$this->uname'";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            return true;
        }
        else{
            return false;
        }
    }
    public function login($uname,$upass){
        $sql	= "SELECT * FROM user WHERE uname='$uname' AND upass='$upass'";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)==1){
            $row    = mysqli_fetch_array($sqlID);
            $this->uid=$row['uid'];
            $this->old_user($this->uid);
            return true;
        }
        else{
            return false;
        }
    }
    public function selectall($search){
        if($search=="all"){
            $sql	= "SELECT * FROM user WHERE uid<>'$this->uid'";
        }
        else{
            $sql	= "SELECT * FROM user WHERE uid<>'$this->uid' AND name LIKE '%$search%'";
        }
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            $this->all=$sqlID;
            return true;
        }
        else{
            return false;
        }
    }
    
    public function next(){
        if($row    = mysqli_fetch_array($this->all)){
            $this->uid      = $row['uid'];
            $this->uname    = $row['uname'];
            $this->upass    = $row['upass'];
            $this->name     = $row['name'];
            $this->dp       = $row['dp'];
            $this->email    = $row['email'];
            $this->city     = $row['city'];
            $this->gender   = $row['gender'];
            $this->dob      = $row['dob'];
            return true;
        }
        else{
            return false; 
        }
    }
    public function getuid(){
        return $this->uid;
    }
    public function getuname(){
        return $this->uname;
    }
    public function getupass(){
        return $this->upass;
    }
    public function getname(){
        return $this->name;
    }
    public function getdp(){
        return $this->dp;
    }
    public function getemail(){
        return $this->email;
    }
    public function getcity(){
        return $this->city;
    }
    public function getgender(){
        return $this->gender;
    }
    public function getdob(){
        return $this->dob;
    }
    public function report(){
        return mysqli_error($this->con);
    }
}
?>