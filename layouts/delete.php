<?php
session_start();
require '../admin.php';

$id = $_GET['id'];
$Validator = new Validator();
if(!$Validator->validate($id, 4)){
    $message =  'Invalid Id';
}else{
    $dbObj = new database;

    $sql = "select * from user where id = $id";
    $result = $dbObj->doQuery($sql);

    if(mysqli_num_rows($result) == 1){

        $data = mysqli_fetch_assoc($result);
        $dbObj2 = new database;
        $sql = "delete from user where id = $id ";
        $result = $dbObj2->doQuery($sql);
        if($result){
            unlink('../uploads/'.$data['image']);
            $message = 'raw deleted';
        }else{
            $message = 'error Try Again !!!!!! ';
        }
    }else{
        $message = 'Error In User Id ';
    }
}

$_SESSION['Message'] = ["Message"=>$message];

header("Location: index.php");