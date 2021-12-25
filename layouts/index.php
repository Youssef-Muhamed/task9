<?php
session_start();
require '../dbconnect.php';

$dbObj = new database;

$sql = "select * from user ";

$result = $dbObj->doQuery($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- custom css -->
</head>
<body>
<!-- container -->
<div class="container">
    <div class="page-header">
        <h1>Read</h1>
        <br>
        <?php

        if(isset($_SESSION['Message'])){
            foreach ($_SESSION['Message'] as $key=>$value){
                echo "* " . $key . ' : ' .$value;
            }
            unset($_SESSION['Message']);
        }
        ?>
    </div>
    <?php
while($data = mysqli_fetch_assoc($result)){
    ?>

    <div class="row my-5">
        <div class="col-sm-10">
            <div class="card " style="max-width: 90%;">
                <div class="row">
                    <div class="col-md-5">
                        <img src="../uploads/<?php echo $data['image'];?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-7 fs-1">
                        <div class="card-body">
                            <h3 class="card-title fs-1"><?php echo $data['title'];?></h3>
                            <p class="card-text fs-1"><?php echo $data['content'];?></p>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end p-5">
                            <a href='delete.php?id=<?php echo $data['id'];?>' class='btn btn-danger btn-lg'>Delete</a>
                            <a href='edit.php?id=<?php echo $data['id'];?>' class='btn btn-primary btn-lg '>Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
    <a href='create.php' class='btn btn-success btn-lg my-3 p-3'>+ New User</a>

</div>
<!-- end .container -->
<!-- Query (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>