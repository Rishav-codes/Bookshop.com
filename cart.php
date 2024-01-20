<?php include_once "connect.php";

if (!isset($_SESSION['account'])) {
    echo "<script>window.open('login.php','_self')</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>

    <?php include_once "header.php";

    // Calling Orders and order item

    $user_id = $getuser['user_id'];
    $order = mysqli_query($connect, "SELECT * FROM orders LEFT JOIN coupon ON orders.coupon_id= coupon.c_id WHERE user_id='$user_id' and is_ordered='0'");
    $myorder = mysqli_fetch_array($order);

    $count_myorder = mysqli_num_rows($order);
    ?>

    <div class="container p-5">
        <div class="row">

            <?php
            if ($count_myorder > 0) :
                $myorderid = $myorder['order_id'];
                // getting order items

                $myorderitems = mysqli_query($connect, "SELECT * FROM order_items JOIN books ON order_items.book_id=books.id  where order_id = '$myorderid'");
                $count_order_items = mysqli_num_rows($myorderitems);

                if ($count_order_items) :
            ?>

                    <div class="col-9">
                        <h1> My Cart(<?= $count_order_items; ?>)</h1>

                        <div class="row">
                            <?php

                            $total_amt = $total_discounted_amt = 0;

                            while ($order_item = mysqli_fetch_array($myorderitems)) :

                                $price = $order_item['qty'] * $order_item['price'];
                                $discount_price = $order_item['qty'] * $order_item['discount_price'];

                            ?>
                                <div class="col-12 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-2">
                                                    <img src="images/<?= $order_item['cover_image']; ?>" class="w-100" alt="">
                                                </div>
                                                <div class="col-10">
                                                    <h2 class="h6 text-truncate"><?= $order_item['title']; ?></h2>
                                                    <h6>Author: <?= $order_item['author']; ?></h6>
                                                    <h6><span class="text-primary">Rs.<?= $order_item['discount_price']; ?></span> <span class="text-muted small">Rs.<del class="text-danger"><?= $order_item['price']; ?></del></span></h6>

                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex">
                                                            <a href="cart.php?book_id=<?= $order_item['id']; ?>&dfc=true" class="btn btn-danger">-</a>
                                                            <span class="btn "><?= $order_item['qty']; ?></span>
                                                            <a href="cart.php?book_id=<?= $order_item['id']; ?>&atc=true" class="btn btn-success">+</a>
                                                        </div>
                                                        <a href="cart.php?delete_item=<?= $order_item['oi_id']; ?>" class="btn btn-dark">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                $total_amt += $price;
                                $total_discounted_amt += $discount_price;
                            endwhile; ?>
                        </div>
                    </div>
                    <div class="col-3">
                        <h2>Price Break</h2>
                        <div class="list-group">
                            <span class="list-group-item list-group-action d-flex justify-content-between bg-primary text-white">
                                <span>Total Amount</span>
                                <span><?= $total_amt; ?>/-</span>
                            </span>
                            <span class="list-group-item list-group-action d-flex justify-content-between bg-warning text-white">
                                <span>Total Discount</span>
                                <span><?= $amount_before_tax = $total_amt - $total_discounted_amt; ?>/-</span>
                            </span>
                            <?php
                            if ($myorder['coupon_id']) :
                            ?>
                                <span class="list-group-item list-group-action bg-warning text-black">
                                    <div class="d-flex justify-content-between">
                                        <span>Coupon Discount</span>
                                        <span class="fw-bold"><?= $coupon_amount = $myorder['coupon_amount']; ?>/-</span>
                                    </div>
                                    <div class="text-center justify-content-between">
                                        <small class="fw-bold ">Coupon Applied - <?= $myorder['coupon_code']; ?>
                                            <a href="cart.php?remove_coupon=<?= $myorder['order_id']; ?>" class="fw-bold text-decoration-none text-danger">X</a>
                                        </small>
                                    </div>
                                </span>
                            <?php endif; ?>

                            <span class="list-group-item list-group-action d-flex justify-content-between bg-danger text-white">
                                <span>Total TAX(GST)</span>
                                <span><?= $tax = $total_discounted_amt * 0.18; ?>/-</span>
                            </span>
                            <span class="list-group-item list-group-action d-flex justify-content-between bg-success text-white">
                                <span>
                                    <h5>Payable Amount</h5>
                                </span>
                                <span>
                                    <h5><?php

                                        $total_payable_amount = $total_discounted_amt + $tax;

                                        if ($myorder['coupon_id']) {
                                            echo $total_payable_amount - $coupon_amount;
                                        } else {
                                            echo $total_payable_amount;
                                        }
                                        ?>/-</h5>
                                </span>
                            </span>
                        </div>
                        <div class="d-flex mt-3 justify-content-between">
                            <a href="index.php" class="btn btn-dark btn-lg">Go Back</a>
                            <a href="checkout.php" class="btn btn-primary btn-lg">Checkout</a>
                        </div>

                        <?php
                        if (!$myorder['coupon_id']) :
                        ?>
                            <div class="mt-3">
                                <form action="" method="post" class="d-flex mt-5">
                                    <input type="text" placeholder="Enter Coupon Code" name="code" class="form-control">
                                    <input type="submit" value="Apply" class="btn btn-dark" name="apply">
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
            <?php else :
                    echo "<h2 class='mb-4'>Hey, Your Cart is Empty!</h2><br><h5>There is nothing in your cart.Let's add some items.";
                    echo "<h2 class='mt-5'><a href='index.php'class='btn btn-warning btn-lg '>EXPLORE NOW</a></h2>";
                endif;
            endif;
            ?>
        </div>
    </div>


    <?php
    // Add to cart

    if (isset($_GET['book_id']) && isset($_GET['atc'])) {
        //  Check User Login or Not

        if (!isset($_SESSION['account'])) {
            echo "<script>window.open('login.php','_self')</scrip>";
        }

        //  And if Login.... Page will be Continue..

        $book_id = $_GET['book_id'];
        $user_id = $getuser['user_id'];

        // Checking Order already exists or not

        $check_order = mysqli_query($connect, "SELECT * FROM orders where user_id='$user_id' and is_ordered='0'");
        $count_check_order = mysqli_num_rows($check_order);

        if ($count_check_order < 1) {
            // Not exists previously that's why we need to create new order in order table
            $create_order = mysqli_query($connect, "INSERT INTO orders(user_id) value('$user_id')");
            $created_order_id = mysqli_insert_id($connect);

            // Inserting new order item
            $create_order_item = mysqli_query($connect, "INSERT INTO order_items(order_id,book_id) value('$created_order_id','$book_id')");
        } else {
            // Already Exixts order work
            $current_order = mysqli_fetch_array($check_order);
            $current_order_id = $current_order['order_id'];

            // Checking if order item already  exist or not
            $check_order_item = mysqli_query($connect, "SELECT * FROM order_items where (order_id='$current_order_id' AND book_id='$book_id')");
            $current_order_item = mysqli_fetch_array($check_order_item);
            $count_current_order_item = mysqli_num_rows($check_order_item);

            if ($count_current_order_item > 0) {
                // ONly need to update quantity of item in order_items table
                $current_order_item_id = $current_order_item['oi_id'];
                $query_for_qty_update = mysqli_query($connect, "UPDATE order_items SET qty=qty+1 WHERE oi_id='$current_order_item_id'");
            } else {
                $create_order_item = mysqli_query($connect, "INSERT INTO order_items(order_id,book_id) value('$current_order_id','$book_id')");
            }
        }

        // Refresh page
        echo "<script>window.open('cart.php','_self')</script>";
    }

    // delete from cart

    if (isset($_GET['book_id']) && isset($_GET['dfc'])) {
        //  Check User Login or Not

        if (!isset($_SESSION['account'])) {
            echo "<script>window.open('login.php','_self')</scrip>";
        }

        //  And if Login.... Page will be Continue..

        $book_id = $_GET['book_id'];
        $user_id = $getuser['user_id'];

        // Checking Order already exists or not

        $check_order = mysqli_query($connect, "SELECT * FROM orders where user_id='$user_id' and is_ordered='0'");
        $count_check_order = mysqli_num_rows($check_order);

        // Already Exixts order work
        $current_order = mysqli_fetch_array($check_order);
        $current_order_id = $current_order['order_id'];

        // Checking if order item already  exist or not
        $check_order_item = mysqli_query($connect, "SELECT * FROM order_items where (order_id='$current_order_id' AND book_id='$book_id')");
        $current_order_item = mysqli_fetch_array($check_order_item);
        $count_current_order_item = mysqli_num_rows($check_order_item);

        if ($count_current_order_item > 0) {
            // ONly need to update quantity of item in order_items table
            $current_order_item_id = $current_order_item['oi_id'];

            $qty = $current_order_item['qty'];

            if ($qty == 1) {
                $delete_query_for_order_id = mysqli_query($connect, "DELETE FROM order_items WHERE oi_id='$current_order_item_id'");
            } else {
                $query_for_qty_update = mysqli_query($connect, "UPDATE order_items SET qty=qty-1 WHERE oi_id='$current_order_item_id'");
            }
        }

        // Refresh page
        echo "<script>window.open('cart.php','_self')</script>";
    }

    // add coupon logic

    if (isset($_POST['apply'])) {
        $code = $_POST['code'];

        $calling_coupon = mysqli_query($connect, "SELECT * FROM coupon WHERE coupon_code='$code'");
        $getCoupon = mysqli_fetch_array($calling_coupon);
        $count_coupon = mysqli_num_rows($calling_coupon);

        if ($count_coupon > 0) {
            // Updating Coupon Id in Order Record
            $coupon_id = $getCoupon['c_id'];
            $update_order = mysqli_query($connect, "UPDATE orders SET coupon_id = '$coupon_id' WHERE order_id ='$myorderid'");

            echo "<script>window.open('cart.php','_self')</script>";
        } else {
            echo "<script>alert('Invalid Coupon Code')</script>";
        }
    }


    // delete item directly


    if (isset($_GET['delete_item'])) {
        $item_id = $_GET['delete_item'];

        $queryForDeleteItem = mysqli_query($connect, "DELETE FROM order_items where oi_id='$item_id'");

        if ($queryForDeleteItem) {
            echo "<script>window.open('cart.php','_self')</script>";
        } else {
            echo "<script>alert('failed to delete')</script>";
        }
    }

    // Remove Coupon

    if (isset($_GET['remove_coupon'])) {
        $id = $_GET['remove_coupon'];

        $queryForRemoveCoupon = mysqli_query($connect, "UPDATE orders SET coupon_id = 'null'  where order_id='$id'");

        if ($queryForRemoveCoupon) {
            echo "<script>window.open('cart.php','_self')</script>";
        } else {
            echo "<script>alert('failed to remove coupon')</script>";
        }
    }
    ?>