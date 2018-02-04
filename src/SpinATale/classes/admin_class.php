<?php

class admin extends config{
    private $aid,$auname,$apass;
    private $con;
    
    public function admin(){
        $this->con  = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_database);
        if(!$this->con) {
            die("<h1>Database Error</h1><h3>".mysqli_error($this->con)."</h3>");
        }
    }
    public function old_admin($aid){
        $this->aid       = $aid;
        $sql	= "SELECT * FROM admin WHERE aid='$this->aid'";
        $sqlID	= mysqli_query($this->con,$sql);
        if($sqlID){
            $row    = mysqli_fetch_array($sqlID);
            
            $this->auname    = $row['auname'];
            $this->apass    = $row['apass'];            
            return true;
        }
        else{
            return false; 
        }
    }
    
    public function new_admin($_POST){
        $this->auname    = mysqli_real_escape_string($this->con,$_POST['auname']);
        $this->apass    = mysqli_real_escape_string($this->con,$_POST['apass']);
    }

    public function update($_POST){
        $this->new_admin($_POST);
        $sql        = "UPDATE admin SET auname='$this->auname',apass='$this->apass'";
        $sqlID      = mysqli_query($this->con,$sql);
        if($sqlID){
            return true;
        }
        else {
            return false;
        }
    }
    
    function exists(){
        $sql	= "SELECT * FROM admin WHERE auname='$this->auname' AND apass='$this->apass'";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)==1){
            return true;
        }
        else{
            return false;
        }
    }
    public function login($auname,$apass){
        $sql	= "SELECT * FROM admin WHERE auname='$auname' AND apass='$apass'";
        $sqlID	= mysqli_query($this->con,$sql);
        if(mysqli_num_rows($sqlID)==1){
            $row    = mysqli_fetch_array($sqlID);
            $this->aid=$row['aid'];
            return true;
        }
        else{
            return false;
        }
    }
    public function getaid(){
        return $this->aid;
    }
    public function getauname(){
        return $this->auname;
    }
    public function getapass(){
        return $this->apass;
    }
    public function report(){
        return mysqli_error($this->con);
    }
}

?>