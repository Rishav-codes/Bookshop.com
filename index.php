<?php include_once "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>

    <?php include_once "header.php"; ?>
    <div class="text-white w-100" style="height: 500px; background-image: url('https://images.alphacoders.com/132/1326370.png');">
        <div class="container d-flex flex-column justify-content-center align-items-center">
            <h1 class="mt-5 text-dark font-weight-bolder">Explorer Books</h1>
            <form action="index.php" method="get" class="d-flex justify-content-center flex-column gap-4">
                <input type="search" name="search" value="" class="form-control-lg" size="70">
                <input type="submit" class="btn btn-warning btn-lg " name="find">
            </form>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row ">
            <?php
            if (isset($_GET['find'])) {
                $search = $_GET['search'];
                $query = mysqli_query($connect, "SELECT * FROM books JOIN categories ON books.category = categories.cat_id WHERE title LIKE'%$search%' OR author LIKE '%$search%' OR cat_title LIKE '%$search%'");
            } else {
                if (isset($_GET['cat_id'])) {
                    $cat_id = $_GET['cat_id'];
                    $query = mysqli_query($connect, "SELECT * FROM books JOIN categories ON books.category = categories.cat_id WHERE cat_id ='$cat_id'");
                } else {
                    $query = mysqli_query($connect, "SELECT * FROM books JOIN categories ON books.category = categories.cat_id");
                }
            }

            $count = mysqli_num_rows($query);
            if ($count < 1) {
                echo "<h2 class='display-3'>OOPS!!<br>Book Not Found!</h2>";
            }
            while ($data = mysqli_fetch_array($query)) :
            ?>
                <div class="col-3">
                    <div class="card mt-3">
                        <img src="<?= 'images/' . $data['cover_image']; ?>" alt="" class="w-100" style='height:300px;object-fit:contain'>
                        <div class="card-body gap-4">
                            <h2 class="h5">Rs.<?= $data['price']; ?>/-<del><?= $data['discount_price']; ?>/-</del></h2>
                            <h2 class="h6 text-truncate" title="<?= $data['title']; ?>"><?= $data['title']; ?></h2>
                            <span class="bg-success text-white badge"><?= $data['cat_title']; ?></span>

                            <a href="view.php?book_id=<?= $data['id']; ?>" class="btn btn-info">View</a>

                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    </div>

</body>

</html>