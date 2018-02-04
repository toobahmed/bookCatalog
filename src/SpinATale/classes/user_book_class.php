<?php

class user_book extends config{
    private $id,$uid,$bid,$a_date,$category;
    private $all;
    private $con;
    
    public function user_book($uid){
        $this->con  = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_database);
        if(!$this->con) {
            die("<h1>Database Error</h1><h3>".mysqli_error($this->con)."</h3>");
        }
        $this->uid=$uid;
    }
    public function old_user_book($id){
        $this->id       = $id;
        $sql	= "SELECT * FROM user_book WHERE id='$this->id' AND uid='$this->uid'";
        $sqlID	= mysqli_query($this->con,$sql);
        if($sqlID){
            $row    = mysqli_fetch_array($sqlID);
            
            $this->bid     = $row['bid'];
            $this->a_date   = $row['a_date'];
            $this->category   = $row['category'];
            
            return true;
        }
        else{
            return false; 
        }
    }
    public function new_user_book($_POST){
        
        $this->bid        = mysqli_real_escape_string($this->con,$_POST['bid']);
        $this->a_date     = time();
        $this->category   = mysqli_real_escape_string($this->con,$_POST['category']);
    }
     
    public function insert(){
        if(!$this->exists()){
            $sql        = "INSERT INTO user_book (uid,bid,category,a_date) VALUES ('$this->uid','$this->bid','$this->category','$this->a_date')";
            $sqlID      = mysqli_query($this->con,$sql);
            if($sqlID)
                return true;            
        }
        return false;        
    }
    public function update($category){
        $this->category   = mysqli_real_escape_string($this->con,$category);
        $this->a_date     = time();
        $sql        = "UPDATE user_book SET category='$this->category', a_date='$this->a_date' WHERE id='$this->id'";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID){
            return true;
        }
        else {
            return false;
        }
    }
    public function delete(){
        $sql        = "DELETE FROM user_book WHERE id='$this->id'";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID){
            return true;
        }
        else {
            return false;
        }
    }
    public function exists($bid){
        $sql	= "SELECT * FROM user_book WHERE uid='$this->uid' AND bid='$bid'";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            $row    = mysqli_fetch_array($sqlID);
            $this->old_user_book($row['id']);
            return true;
        }
        else{
            return false;
        }
    }
    public function selectall($category){
        if($category==="all"){
            $sql	= "SELECT * FROM user_book WHERE uid='$this->uid'";
        }
        else{
            $sql	= "SELECT * FROM user_book WHERE uid='$this->uid' AND category='$category'";
        }
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            $this->all=$sqlID;
        }
        return mysqli_num_rows($sqlID);
    }
    
    public function next(){
        if($row    = mysqli_fetch_array($this->all)){
            $this->id       = $row['id'];
            $this->uid      = $row['uid'];
            $this->bid      = $row['bid'];
            $this->a_date   = $row['a_date'];
            $this->category = $row['category'];
            return true;
        }
        else{
            return false; 
        }
    }
    public function getid(){
        return $this->id;
    }
    public function getuid(){
        return $this->uid;
    }
    public function getbid(){
        return $this->bid;
    }
    public function geta_date(){
        return $this->a_date;
    }
    public function getcategory(){
        return $this->category;
    }
    public function report(){
        return mysqli_error($this->con);
    }
}

?>