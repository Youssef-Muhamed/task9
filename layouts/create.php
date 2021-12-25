<?php
session_start();
require '../admin.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

// CODE ......
    $AllowExtention = array("jpg","png","jpeg");

    $title     = $_POST['title'];
    $content    = $_POST['content'];
    $fileName = $_FILES['image']['name'];
    $fileTmp = $_FILES['image']['tmp_name'];
    $tmp = explode('.',$fileName);
    $fileExtention = end($tmp );
    $admin = new Create($title,$content,$fileName,$fileTmp,$fileExtention);
    $admin->create();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Add Item</h2>
    <?php
    if(isset($_SESSION['Message'])){
        foreach($_SESSION['Message'] as $key => $val){
            echo '* '.$key." : ".$val.'<br>';
        }
        unset($_SESSION['Message']);
    }
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="exampleInputName">Title</label>
            <input type="text" class="form-control" id="exampleInputName" name="title" placeholder="Enter Name">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Content</label>
            <textarea class="form-control" id="exampleInputEmail1" name="content"></textarea>
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Upload Image</label>
            <input type="file" id="exampleInputEmail1" name="image" >
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>
</body>
</html>
