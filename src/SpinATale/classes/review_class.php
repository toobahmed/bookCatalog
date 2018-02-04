<?php

class review extends config{
    private $rid,$bid,$uid,$s_date,$des,$rating;
    private $all;
    private $con;
    
    public function review(){
        $this->con  = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_database);
        if(!$this->con) {
            die("<h1>Database Error</h1><h3>".mysqli_error($this->con)."</h3>");
        }
    }
    public function old_review($rid){
        $this->rid      = $rid;
        $sql	= "SELECT * FROM review WHERE rid='$this->rid'";
        $sqlID	= mysqli_query($this->con,$sql);
        if($sqlID){
            $row    = mysqli_fetch_array($sqlID);
            
            $this->uid      = $row['uid'];            
            $this->r_date   = $row['s_date'];
            $this->des     = $row['des'];
            $this->rating   = $row['rating'];
            
            return true;
        }
        else{
            return false; 
        }
    }
    public function new_review($_POST){
        $this->bid      = mysqli_real_escape_string($this->con,$_POST['bid']);
        $this->uid      = mysqli_real_escape_string($this->con,$_POST['uid']);        
        $this->s_date   = time();
        $this->des     = mysqli_real_escape_string($this->con,$_POST['des']);
        $this->rating   = 0;
    }
     
    public function post(){
        $sql        = "INSERT INTO review (bid,uid,des,s_date) VALUES ('$this->bid','$this->uid','$this->des','$this->s_date')";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID)
            return true;            
        return false;        
    }
    public function update($_POST){
        $this->rating   = mysqli_real_escape_string($this->con,$_POST['rating']);
        $sql        = "UPDATE review SET rating='$this->rating' WHERE rid='$this->rid'";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID){
            return true;
        }
        else {
            return false;
        }
    }
    public function delete(){
        $sql        = "DELETE FROM review WHERE rid='$this->rid'";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID){
            return true;
        }
        else {
            return false;
        }
    }
    public function read(){
        $sql	= "SELECT * FROM review WHERE rid='$this->rid'";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            old_review($this->rid);
            return true;
        }
        else{
            return false;
        }
    }
    
    public function selectall($bid){
        $sql	= "SELECT * FROM review WHERE bid=$bid";
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
            $this->rid      = $row['rid'];
            $this->bid      = $row['bid'];
            $this->uid      = $row['uid'];            
            $this->s_date   = $row['s_date'];
            $this->des     = $row['des'];
            $this->rating   = $row['rating'];
            return true;
        }
        else{
            return false; 
        }
    }
    
    public function getrid(){
        return $this->rid;
    }
    public function getbid(){
        return $this->bid;
    }
    public function getuid(){
        return $this->uid;
    }
    public function gets_date(){
        return $this->s_date;
    }
    public function getdes(){
        return $this->des;
    }
    public function getrating(){
        return $this->rating;
    }
    public function report(){
        return mysqli_error($this->con);
    }
}

?>