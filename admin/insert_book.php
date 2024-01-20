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
    <title>Manage Book-BookShop | Admin Panel</title>
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
                <h2 class="text-white p-0 m-0">Insert New Book</h2>
                <a href="manage_book.php" class="btn btn-light">Go Back</a>
            </div>
        </div>
        <div class="card">
                <div class="card-header">
                    <h5>Insert Book Detail</h5>
                </div>
                    <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="row">
                        <div class="mb-2 col">
                            <label for="author">Author</label>
                            <input type="text" name="author" id="author" class="form-control">
                        </div>
                        <div class="mb-2 col">
                            <label for="no_of_page">No. of page</label>
                            <input type="text" name="no_of_page" id="no_of_page" class="form-control">
                        </div>
                        </div>
                        <div class="row">
                        <div class="mb-2 col">
                            <label for="price">Price</label>
                            <input type="text" name="price" id="price" class="form-control">
                        </div>
                        <div class="mb-2 col">
                            <label for="discount_price">Discount_price</label>
                            <input type="text" name="discount_price" id="discount_price" class="form-control">
                        </div>
                        </div>
                       <div class="row">
                       <div class="mb-2 col">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">Select Here</option>
                            <?php
                                $query = mysqli_query($connect,"SELECT * from categories");
                                while($row = mysqli_fetch_array($query)){
                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                    echo "<option value='$cat_id'>$cat_title</option>";
                                }
                            ?>
                            </select>
                        </div>
                        <div class="mb-2 col">
                            <label for="nos">Quantity</label>
                            <input type="text" name="nos" id="nos" class="form-control">
                        </div>
                        <div class="mb-2 col">
                            <label for="cover_image">Cover Image</label>
                            <input type="file" name="cover_image" id="cover_image" class="form-control">
                        </div>
                       </div>
                        <div class="mb-2">
                            <label for="description">Description</label>
                            <textarea  cols="30" rows="4" type="text" name="description" id="description" class="form-control"></textarea>
                        </div>
                        <div class="mb-2">
                            <label for="isbn">ISBN</label>
                            <input type="text" name="isbn" id="isbn" class="form-control">
                        </div>
                       <div class="row">
                       <div class="mb-2 col">
                            <input type="submit" name="create_book" class="btn btn-success" value="Insert Book">
                        </div>
                        <div class="mb-2 col">
                            <input type="reset" class="btn btn-danger" value="Reset">
                        </div>
                       </div>
                    </form>

                    <?php
                        if(isset($_POST['create_book'])){
                            $title = $_POST['title'];
                            $author = $_POST['author'];
                            $no_of_page = $_POST['no_of_page'];
                            $price = $_POST['price'];
                            $discount_price = $_POST['discount_price'];
                            $category = $_POST['category'];
                            $nos = $_POST['nos'];
                            $description = $_POST['description'];
                            $isbn = $_POST['isbn'];

                            // Image work

                            $cover_image = $_FILES['cover_image']['name'];
                            $tmp_cover_image = $_FILES['cover_image']['tmp_name'];
                            move_uploaded_file($tmp_cover_image,"../images/$cover_image");

                            $query = mysqli_query($connect,"INSERT INTO books(title,author,no_of_page,price,discount_price,category,nos,description,isbn,cover_image) value('$title','$author','$no_of_page','$price','$discount_price','$category','$nos','$description','$isbn','$cover_image')");

                            if($query){
                                echo "<script>window.open('manage_book.php','_self')</script>";
                            }
                            else{
                                echo "<script>alert('Failed')</script>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>



</body>
</html>