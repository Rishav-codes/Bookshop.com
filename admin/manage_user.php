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
    <title>Manage User - BookShop | Admin Panel</title>
</head>
<body class="bg-secondary">
 <?php include_once "./admin_header.php";?>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-3">
        <?php
        include_once "sidebar.php";
        ?>
        </div>
        <div class="col-9">
            <div class="row">
                <div class="col-12 mb-3">
                    <h2 class="text-white">
                        Manage Users
                    </h2>
                </div>
            </div>
            <table class="table table-hover table-bodered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $callingusers = mysqli_query($connect,"SELECT * FROM accounts");
                    while($data = mysqli_fetch_array($callingusers)):
                        ?>
                        <tr>
                            <td><?=$data['user_id'];?></td>
                            <td><?=$data['name'];?></td>
                            <td><?=$data['contact'];?></td>
                            <td><?=$data['email'];?></td>
                            <td><?=($data['isAdmin'])? "Administrator":"Standard";?></td>>
                            <td>
                                <div class="btn-group">
                                <a href="manage_user.php?u_id=<?=$data['user_id'];?>" class="btn btn-danger">X</a>
                                <a href="" class="btn btn-info">Edit</a>
                                <a href="" class="btn btn-success">view</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile;?>
                </tbody>
            </table>
        </div>

    </div>
</div>
</body>
</html>

<?php
if(isset($_GET['u_id'])){
    $id = $_GET['u_id'];

    $query = mysqli_query($connect,"DELETE FROM accounts WHERE user_id='$id'");
    if($query){
        echo "<script>window.open('manage_user.php','_self')</script>";
    }
    else{
        echo "<script>alert('Fail to Delete')</script>";
    }
}
?>