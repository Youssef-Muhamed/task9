<?php
require 'dbconnect.php';
require 'validator.php';

class create{
    private $title;
    private $content;
    private $fileName;
    private $fileTmp;
    private $AllowExtention;
    private $fileExtention;

    function __construct($title,$content,$fileName,$fileTmp,$fileExtention){

        $this->title     = $title;
        $this->content   = $content;
        $this->fileName  = $fileName;
        $this->fileTmp   = $fileTmp;
        $this->fileExtention   = $fileExtention;
    }


    public function create(){
        // logic .....

        $Validator = new Validator();

        $this->title = $Validator->Clean($this->title);

        $errors = [];

        # Validate Title
        if(empty($this->title)){
            $errors['title']  = "Field Required...";
        }
        if(strlen($this->title) < 6){
            $errors['title']  = "Must Be Greter Than 6chr";
        }
        # Validate Content
        if(empty($this->content)){
            $errors['content'] = "Field Required...";
        }
        if(strlen($this->content) < 20){
            $errors['Content']  = "Must Be Greter Than 20chr";
        }
        if (!$Validator->validate($this->fileName, 1)) {
            $errors['Image'] = 'Field Required';
        }
        if (!$Validator->validate($this->fileExtention, 5)) {
            $errors['Image'] = 'Error In Extension';
        }

        # Check Errors .....
        if(count($errors)>0){
            $_SESSION['Message'] = $errors;
        }else{
            $newFileName = rand().time(). '_' . $this->fileName;
            move_uploaded_file($this->fileTmp,"../uploads/" . $newFileName);
            $dbObj = new database;

            $sql = "insert into user (title,content,image) values ('$this->title','$this->content','$newFileName')";

            $result = $dbObj->doQuery($sql);

            if($result){
                $message = "Data Inserted";
            }else{
                $message = "Error Try Again";
            }

            $_SESSION['Message'] = ['message' => $message];

        }
    }
}

