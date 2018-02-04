<?php

class book extends config{
    private $bid,$title,$cover,$author,$r_date,$des;
    private $all;
    private $con;
    
    public function book(){
        $this->con  = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_database);
        if(!$this->con) {
            die("<h1>Database Error</h1><h3>".mysqli_error($this->con)."</h3>");
        }
    }
    public function old_book($bid){
        $this->bid       = $bid;
        $sql	= "SELECT * FROM book WHERE bid='$this->bid'";
        $sqlID	= mysqli_query($this->con,$sql);
        if($sqlID){
            $row    = mysqli_fetch_array($sqlID);
            
            $this->title    = $row['title'];
            $this->cover    = $row['cover'];
            $this->author   = $row['author'];
            $this->r_date   = $row['r_date'];
            $this->des     = $row['des'];
            
            return true;
        }
        else{
            return false; 
        }
    }
    public function new_book($_POST){
        $this->title    = mysqli_real_escape_string($this->con,$_POST['title']);
        $this->author   = mysqli_real_escape_string($this->con,$_POST['author']);
        $this->r_date   = mysqli_real_escape_string($this->con,$_POST['r_date']);
        $this->des     = mysqli_real_escape_string($this->con,$_POST['des']);
        
        if(isset($_FILES) && $_FILES["cover"]["tmp_name"]!=="") {
            /* Process uploaded pic and check for errors */
            $allowedExts = array("jpeg", "jpg", "png");
            $allowedMimes = array("image/jpeg","image/jpg","image/pjpeg","image/x-png","image/png","image/bmp");
            $allowedMaxSize = 2; // in MB
            $hash = md5(time().rand(0,99999));
            $temp = explode(".", $_FILES["cover"]["name"]);
            $pic_extension    = end($temp);
            $pic_filename     = $hash.".".$pic_extension;
            $pic_dir          ="cover";
            
            if($_FILES["cover"]["size"] > ($allowedMaxSize*1024*1024)){
                $this->error.="Picture should not be larger than ".$allowedMaxSize."MB";
            }
            if (in_array(strtolower($_FILES["cover"]["type"]),$allowedMimes) && in_array(strtolower($pic_extension),$allowedExts)) {
                if ($_FILES["cover"]["error"] > 0) {
                    $this->error.="An error ocurred in the picture you uploaded";                                             
                } else {                                                
                    if (file_exists($pic_dir."/".$pic_filename)) {                                                    
                    } else {
                        move_uploaded_file($_FILES["cover"]["tmp_name"],$pic_dir."/".$pic_filename);
                        $this->cover = $pic_dir."/".$pic_filename;
                    }
                }
                
            } else {
                $this->error.="Invalid picture";
            }            
        }
    }
     
    public function insert(){
        if(!$this->exists()){
            $sql        = "INSERT INTO book(title,author,des,r_date,cover) VALUES('$this->title','$this->author','$this->des','$this->r_date','$this->cover')";
            $sqlID      = mysqli_query($this->con,$sql);
            if($sqlID)
                return true;            
        }
        return false;        
    }
    public function update($_POST){
        $this->new_book($_POST);
        $sql        = "UPDATE book SET title='$this->title',author='$this->author',des='$this->des',r_date='$this->r_date',cover='$this->cover' WHERE bid='$this->bid'";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID){
            return true;
        }
        else {
            return false;
        }
    }
    public function delete(){
        $sql1        = "DELETE FROM book WHERE bid='$this->bid'";
        $sql2        = "DELETE FROM user_book WHERE bid='$this->bid'";
        $sql3        = "DELETE FROM review WHERE bid='$this->bid'";
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
    function exists(){
        $sql	= "SELECT * FROM book WHERE title='$this->title' AND author='$this->author'";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function selectall($search){
        if($search=="all"){
            $sql	= "SELECT * FROM book WHERE bid<>'$this->bid'";
        }
        else{
            $sql	= "SELECT * FROM book WHERE bid<>'$this->bid' AND title LIKE '%$search%' OR author LIKE '%$search%'";
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
            $this->bid      = $row['bid'];
            $this->title    = $row['title'];
            $this->cover    = $row['cover'];
            $this->author   = $row['author'];
            $this->r_date   = $row['r_date'];
            $this->des     = $row['des'];
            return true;
        }
        else{
            return false; 
        }
    }
    public function getbid(){
        return $this->bid;
    }
    public function gettitle(){
        return $this->title;
    }
    public function getcover(){
        return $this->cover;
    }
    public function getauthor(){
        return $this->author;
    }
    public function getr_date(){
        return $this->r_date;
    }
    public function getdes(){
        return $this->des;
    }
    public function report(){
        return mysqli_error($this->con);
    }
}

?>