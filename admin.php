<?php
require 'dbconnect.php';
require 'validator.php';

# Class For Parint .................

class User {
    public $title;
    public $content;
    public $fileName;
    public $fileTmp;
    public $fileExtention;

    function __construct($title,$content,$fileName,$fileTmp,$fileExtention){

        $this->title     = $title;
        $this->content   = $content;
        $this->fileName  = $fileName;
        $this->fileTmp   = $fileTmp;
        $this->fileExtention   = $fileExtention;
    }

}
# Class For Create .................

class Create extends User {

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
# Class For Edit .................
class Edit extends User {

    public function edit()
    {
        // logic .....

        $Validator = new Validator();

        $this->title = $Validator->Clean($this->title);

        $errors = [];

        # Validate Title
        if (empty($this->title)) {
            $errors['title'] = "Field Required...";
        }
        if (strlen($this->title) < 6) {
            $errors['title'] = "Must Be Greter Than 6chr";
        }
        # Validate Content
        if (empty($this->content)) {
            $errors['content'] = "Field Required...";
        }
        if (strlen($this->content) < 20) {
            $errors['Content'] = "Must Be Greter Than 20chr";
        }
        # Validate image
        if ($Validator->validate($this->fileName, 1)) {

            if (!$Validator->validate($this->fileExtention, 5)) {
                $errors['Image'] = 'Error In Extension';
            }
        }

        # Check Errors .....
        if (count($errors) > 0) {
            foreach ($errors as $key => $value){
                $message = $key.$value;
                $_SESSION['Message']  = ['Message' => $message];
            }

        } else {

            $dbObj = new database;
            $id = $_GET['id'];
            $sql = "select * from user where id = $id";
            $result = $dbObj->doQuery($sql);
            if (mysqli_num_rows($result) == 1) {
                $data = mysqli_fetch_assoc($result);
            } else {
                $_SESSION['Message'] = ["Message" => "Access Denied"];
                header("Location: index.php");
            }
            $OldImage = $data['image'];


            if ($Validator->validate($this->fileName, 1)) {
                $desPath = '../uploads/' . $this->fileName;

                if (move_uploaded_file($this->fileTmp, $desPath)) {

                    unlink('../uploads/' . $OldImage);
                }
            } else {
                $this->fileName = $OldImage;
            }

            $dbObj2 = new database;
            $sql = "update user set title = '$this->title' , content = '$this->content',image = '$this->fileName'where id = $id";
            $result = $dbObj2->doQuery($sql);
            if ($result) {
                $message = 'Data Updated';
            } else {
                $message = 'Error Try Again' . mysqli_error($con);
            }

        }
        $_SESSION['Message'] = ['message' => $message];
        header("Location: index.php");
    }
}
