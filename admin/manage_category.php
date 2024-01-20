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
    <title>Manage Category - BookShop | Admin Panel</title>
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
                <h2 class="text-white">Manage Category</h2>
            </div>
        </div>

            <div class="row">
                <div class="col-3">
                <div class="card">
                <div class="card-header">
                    <h5>Insert Category Detail</h5>
                </div>
                    <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-2">
                            <label for="cat_title">Category Title</label>
                            <input type="text" name="cat_title" id="cat_title" class="form-control" placeholder="Enter Category Title">
                        </div>
                        <div class="mt-2">
                            <input type="submit" class="btn btn-primary" name="create_category" value="Insert Category">
                        </div>
                    </form>

                    <?php
                        if(isset($_POST['create_category'])){
                        $cat_title = $_POST['cat_title'];
                        
                        $q = mysqli_query($connect,"INSERT INTO categories(cat_title) value('$cat_title')");
                        if($q){
                            echo "<script>window.open('manage_category.php','_self')</script>";
                        }
                        else{
                            echo "<script>alert('Failed')</script>";
                        }
                    }
                    ?>
                </div>
            </div>
                </div>
                <div class="col-9">
                <table class="table table-hover table-bodered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Cat title</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $calling_category = mysqli_query($connect,"SELECT * FROM categories");
                    while($data = mysqli_fetch_array($calling_category)):
                        ?>
                        <tr>
                            <td><?=$data['cat_id'];?></td>
                            <td><?=$data['cat_title'];?></td>
                            <td> <div class="btn-group">
                                <a href="manage_category.php?c_id=<?=$data['cat_id'];?>" class="btn btn-danger">X</a>
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

    </div>
</div>
</body>
</html>

<?php
if(isset($_GET['c_id'])){
    $id = $_GET['c_id'];

    $query = mysqli_query($connect,"DELETE FROM categories WHERE cat_id='$id'");
    if($query){
        echo "<script>window.open('manage_category.php','_self')</script>";
    }
    else{
        echo "<script>alert('Fail to Delete')</script>";
    }
}
?>