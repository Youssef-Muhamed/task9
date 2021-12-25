<?php
session_start();
require '../admin.php';

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

if ($_SERVER['REQUEST_METHOD'] == "POST") {

// CODE ......
    $AllowExtention = array("jpg", "png", "jpeg");

    $title = $_POST['title'];
    $content = $_POST['content'];
    $fileName = $_FILES['image']['name'];
    $fileTmp = $_FILES['image']['tmp_name'];
    $tmp = explode('.', $fileName);
    $fileExtention = end($tmp);
    $edit = new Edit($title, $content, $fileName, $fileTmp, $fileExtention);
    $edit->edit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Edit Account</h2>

    <form action="edit.php?id=<?php echo $data['id']; ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="exampleInputName">Title</label>
            <input type="text" class="form-control" id="exampleInputName" name="title"
                   value="<?php echo $data['title']; ?>" aria-describedby="" placeholder="Enter Name">
        </div>


        <div class="form-group">
            <label for="exampleInputEmail">Content</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="content"
                   value="<?php echo $data['content']; ?>" aria-describedby="emailHelp" placeholder="Enter email">
        </div>

        <div class="form-group">
            <label for="exampleInputPassword">Image</label>
            <input type="file" name="image">
        </div>

        <img src="../uploads/<?php echo $data['image']; ?>" height="80" width="80"><br><br>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>

