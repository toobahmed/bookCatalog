<?php

class message extends config{
    private $mid,$uid1,$uid2,$m_date,$des,$status;
    private $all;
    private $con;
    
    public function message($uid1){
        $this->con  = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_database);
        if(!$this->con) {
            die("<h1>Database Error</h1><h3>".mysqli_error($this->con)."</h3>");
        }
        $this->uid1      = $uid1;
    }
    public function old_message($mid){
        $this->mid      = $mid;
        
        $sql	= "SELECT * FROM message WHERE mid='$this->mid'";
        $sqlID	= mysqli_query($this->con,$sql);
        if($sqlID){
            $row    = mysqli_fetch_array($sqlID);
            
            $this->uid1    = $row['uid1'];
            $this->uid2    = $row['uid2'];            
            $this->m_date  = $row['m_date'];
            $this->des     = $row['des'];
            $this->status  = $row['status'];
            
            return true;
        }
        else{
            return false; 
        }
    }
    public function new_message($_POST){
        $this->uid2      = mysqli_real_escape_string($this->con,$_POST['uid2']);        
        $this->m_date   = time();
        $this->des     = mysqli_real_escape_string($this->con,$_POST['des']);
        $this->status   = "unread";
    }
     
    public function send(){
        $sql        = "INSERT INTO message (uid1,uid2,des,status,m_date) VALUES ('$this->uid1','$this->uid2','$this->des','$this->status','$this->m_date')";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID)
            return true;            
        return false;        
    }
    public function update(){
        $sql        = "UPDATE message SET status='read' WHERE mid='$this->mid'";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID){
            return true;
        }
        else {
            return false;
        }
    }
    public function delete(){
        $sql        = "DELETE FROM message WHERE mid='$this->mid'";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID){
            return true;
        }
        else {
            return false;
        }
    }
    public function isread(){
        $sql	= "SELECT * FROM message WHERE mid='$this->mid' AND status='read'";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function selectall($status,$category){
        if($category=="sent"){
            if($status=="all")
                $sql	= "SELECT * FROM message WHERE uid1=$this->uid1";
            else
                $sql	= "SELECT * FROM message WHERE uid1=$this->uid1 AND status='$status'";
        }
        else{
            if($status=="all")
                $sql	= "SELECT * FROM message WHERE uid2=$this->uid1";
            else
                $sql	= "SELECT * FROM message WHERE uid2=$this->uid1 AND status='$status'";
        }
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)!=0){
            $this->all=$sqlID;
        }
        return mysqli_num_rows($sqlID);
    }
    
    public function next(){
        if($row    = mysqli_fetch_array($this->all)){
            $this->mid      = $row['mid'];
            $this->uid1      = $row['uid1'];
            $this->uid2      = $row['uid2'];            
            $this->m_date   = $row['m_date'];
            $this->des     = $row['des'];
            $this->status   = $row['status'];
            return true;
        }
        else{
            return false; 
        }
    }
    
    public function getmid(){
        return $this->mid;
    }
    public function getuid1(){
        return $this->uid1;
    }
    public function getuid2(){
        return $this->uid2;
    }
    public function getm_date(){
        return $this->m_date;
    }
    public function getdes(){
        return $this->des;
    }
    public function getstatus(){
        return $this->status;
    }
    public function report(){
        return mysqli_error($this->con);
    }
}

?>