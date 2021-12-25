<?php
class database{
    public $server     = "localhost";
    public $dbUser     = "root";
    public $dbPassword = "";
    public $dbName     = "blog";
    public $con        = null;
    function __construct(){
        $this->con =   mysqli_connect($this->server,$this->dbUser,$this->dbPassword,$this->dbName);
        if(!$this->con){
            echo 'Errror : '.mysqli_connect_error();
        }
    }
    function doQuery($sql){
        $result = mysqli_query($this->con,$sql);
        return $result;
    }
    function __destruct(){
        mysqli_close($this->con);
    }

}
