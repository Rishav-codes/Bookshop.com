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
    <title>Manage Coupon - BookShop | Admin Panel</title>
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
                <h2 class="text-white">Manage Coupon</h2>
            </div>
        </div>

            <div class="row">
                <div class="col-3">
                <div class="card">
                <div class="card-header">
                    <h5>Insert Coupon Detail</h5>
                </div>
                    <div class="card-body">
                    <form action="" method="POST">
                        <div class="mb-2">
                            <label for="coupon_code">Coupon Code</label>
                            <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="Enter Coupon Code">
                        </div>
                        <div class="mb-2">
                            <label for="coupon_amount">Coupon Amount</label>
                            <input type="text" name="coupon_amount" id="coupon_amount" class="form-control" placeholder="Enter Coupon Amount">
                        </div>
                        <div class="mt-2">
                            <input type="submit" class="btn btn-primary" name="create_coupon" value="Insert Coupon">
                        </div>
                    </form>

                    <?php
                        if(isset($_POST['create_coupon'])){
                        $coupon_code = $_POST['coupon_code'];
                        $coupon_amount = $_POST['coupon_amount'];
                        
                        $q = mysqli_query($connect,"INSERT INTO coupon(coupon_code,coupon_amount) value('$coupon_code','$coupon_amount')");
                        if($q){
                            echo "<script>window.open('manage_coupon.php','_self')</script>";
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
                        <th>Code</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $calling_coupon = mysqli_query($connect,"SELECT * FROM coupon");
                    while($data = mysqli_fetch_array($calling_coupon)):
                        ?>
                        <tr>
                            <td><?=$data['c_id'];?></td>
                            <td><?=$data['coupon_code'];?></td>
                            <td><?=$data['coupon_amount'];?></td>
                            <td> <div class="btn-group">
                                <a href="" class="btn btn-danger">X</a>
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
if(isset($_GET['coupon_id'])){
    $id = $_GET['coupon_id'];

    $query = mysqli_query($connect,"DELETE FROM coupon WHERE coupon_id='$id'");
    if($query){
        echo "<script>window.open('manage_coupon.php','_self')</script>";
    }
    else{
        echo "<script>alert('Fail to Delete')</script>";
    }
}
?>