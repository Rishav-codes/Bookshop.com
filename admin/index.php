<?php include_once "../connect.php";
// Checking Admin Or Not

if(!isset($_SESSION['admin'])){
    echo"<script>window.open('../login.php','_self')</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookShop | Admin Panel</title>
</head>
<body class="bg-secondary">
 <?php include_once "./admin_header.php";?>

<div class="container mt-5">
    <div class="row">
        <div class="col-3">
           <?php
            include_once "sidebar.php";
           ?>
        </div>
        <div class="col-9">
            <div class="row">
                <div class="col-4">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <h2><?php
                              echo $countbooks = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM books"))
                            ?></h2>
                            <h3>Total Books</h3>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h2><?php
                              echo $countcategory = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM categories"))
                            ?></h2>
                            <h3>Total Category</h3>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <h2><?php
                              echo $countuser = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM accounts"))
                            ?></h2>
                            <h3>Total User</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



</body>
</html>