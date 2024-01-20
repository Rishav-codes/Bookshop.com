<?php include_once "connect.php";

if(!isset($_SESSION['account'])){
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

<?php include_once "header.php"; ?>

<div class="container p-5">
    <div class="row">
        <?php
        $user_id = $getuser['user_id'];
        $order = mysqli_query($connect,"SELECT * FROM orders LEFT JOIN coupon ON orders.coupon_id= coupon.c_id WHERE user_id='$user_id' and is_ordered='1'");

        $count_myorder = mysqli_num_rows($order);
        ?>

        <div class="col-12">
            <h1> My Order(<?=$count_myorder;?>)</h1>
            <div class="row">
            <?php  
                // Calling Orders and order item
            while($myorder = mysqli_fetch_array($order)):
            ?>

                <div class="col-12 mb-2">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between">
                            <span>Order Id: <?=$myorder['order_id'];?></span>
                           <?= ($myorder['coupon_id'])? " <span>Coupon:".$myorder['coupon_code']."</span>":null;?>
                        </div>
                        <div class="card-body d-flex flex-column gap-1">
                            <!-- items -->
                            <?php
                    if($count_myorder > 0 ):
                        $myorderid = $myorder['order_id'];
                        // getting order items
                    
                        $myorderitems = mysqli_query($connect,"SELECT * FROM order_items JOIN books ON order_items.book_id=books.id  where order_id = '$myorderid'");
                        $count_order_items = mysqli_num_rows($myorderitems);
                        $total_amt = $total_discounted_amt = 0;

                        while($order_item = mysqli_fetch_array($myorderitems)):                            
                            $price = $order_item['qty'] * $order_item['price'];
                            $discount_price = $order_item['qty'] * $order_item['discount_price'];
                        ?>
                            <div class="row">

                                    <div class="col-1">
                                        <img src="images/<?=$order_item['cover_image'];?>" class="w-100" alt="">
                                    </div>
                                    <div class="col-10">
                                        <h4 class="text-truncate">Title: <?=$order_item['title'];?></h4>
                                        <span class="h5">Quantity: <?=$order_item['qty'];?></span>
                                        <h5><span class="text-primary">Rs.<?=$order_item['discount_price'];?></span> <span class="text-muted small">Rs.<del class="text-danger"><?=$order_item['price'];?></del></span></h5>
                                    </div>
                            </div>
                            <?php 
                             $total_amt += $price;
                             $total_discounted_amt += $discount_price;

                        endwhile;
                        $amount_before_tax = $total_amt - $total_discounted_amt;
                        $tax = $total_discounted_amt*0.18;
                        $total_payable_amount = $total_discounted_amt + $tax;

                        $coupon_amount = $myorder['coupon_amount'];
                        if($myorder['coupon_id']){
                                $total_payable_amount = $total_payable_amount - $coupon_amount;
                            }
                        else{
                                $total_payable_amount;
                            }
                                    endif; ?>
                            <!-- end items -->
                        </div>
                        <div class="card-footer">
                            <h5 class="text-danger">Total Amount: Rs. <?=$total_payable_amount;?> /-</h5>
                        </div>
                    </div>
                </div>
            <?php endwhile;?>
            </div>
        </div>            
    </div>
</div>


