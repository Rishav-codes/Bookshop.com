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
    <title>Manage Book - BookShop | Admin Panel</title>
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
            <div class="col-12 mb-3 d-flex justify-content-between">
                <h2 class="text-white p-0 m-0">Manage Books (<?php
                              echo $countbooks = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM books"))
                            ?>)</h2>
                <a href="insert_book.php" class="btn btn-light">Insert Books</a>
            </div>
        </div>
            <table class="table table-hover table-bodered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>title</th>
                        <th>author</th>
                        <th>isbn</th>
                        <th>Price</th>
                        <th>image</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $callingbooks = mysqli_query($connect,"SELECT * FROM books");
                    while($data = mysqli_fetch_array($callingbooks)):
                        ?>
                        <tr>
                            <td><?=$data['id'];?></td>
                            <td><?=$data['title'];?></td>
                            <td><?=$data['author'];?></td>
                            <td><?=$data['isbn'];?></td>
                            <td>Rs.<?=$data['discount_price'];?><del> Rs<?=$data['price'];?></del></td>
                            <td><img src="../images/<?=$data['cover_image'];?>" width="40px" height="50px" alt=""></td>
                            <td>
                                <div class="btn-group">
                                <a href="manage_book.php?b_id=<?= $data['id'];?>" class="btn btn-danger">X</a>
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
if(isset($_GET['b_id'])){
    $id = $_GET['b_id'];

    $query = mysqli_query($connect,"DELETE FROM books WHERE id='$id'");
    if($query){
        echo "<script>window.open('manage_book.php','_self')</script>";
    }
    else{
        echo "<script>alert('Fail to Delete')</script>";
    }
}
?>