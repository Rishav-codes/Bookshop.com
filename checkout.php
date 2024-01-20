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
    <link rel="stylesheet" href="style.css">

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

            <div class="col-8">
                <h1>Checkout Here</h1>
                <div class="card mx-3">
                    <div class="card-header">Add Address</div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="mb-3 col">
                                    <label for="">Alternative Name</label>
                                    <input type="text" name="alt_name" class="form-control" value="<?= $getuser['name']; ?>">
                                </div>
                                <div class="mb-3 col">
                                    <label for="">Primary Contact</label>
                                    <input type="tel" name="alt_contact" class="form-control" value="<?= $getuser['contact']; ?>">
                                </div>
                                <div class="mb-3 col">
                                    <label for="">Address Type</label>
                                    <select name="type" class="form-select">
                                        <option value="">Select Address Type</option>
                                        <option value="0">Office</option>
                                        <option value="1">Home</option>
                                        <option value="2">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col">
                                    <label for="">House No</label>
                                    <input type="text" name="house_no" class="form-control" value="">
                                </div>
                                <div class="mb-3 col">
                                    <label for="">Street</label>
                                    <input type="text" name="street" class="form-control" value="">
                                </div>
                                <div class="mb-3 col">
                                    <label for="">Area/Village</label>
                                    <input type="text" name="area" class="form-control" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col">
                                    <label for="">Landmark</label>
                                    <input type="text" name="landmark" class="form-control" value="">
                                </div>
                                <div class="mb-3 col">
                                    <label for="">Pincode</label>
                                    <input type="text" name="pincode" class="form-control" value="">
                                </div>
                                <div class="mb-3 col">
                                    <label for="">City</label>
                                    <input type="text" name="city" class="form-control" value="">
                                </div>
                                <div class="mb-3 col">
                                    <label for="">State</label>
                                    <input type="text" name="state" class="form-control" value="">
                                </div>
                            </div>
                            <div class="row">
                                <input type="submit" name="save_address" value="Save Address" class="btn btn-primary w-100">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-4 ">
                <h2>Saved Address</h2>
                <form action="" method="post">
                    <div class="grid">
                        <?php

                        $callingsavedaddress = mysqli_query($connect, "SELECT * FROM address WHERE user_id ='$user_id'");
                        $count_address = mysqli_num_rows($callingsavedaddress);

                        if ($count_address > 0) :
                            while ($add = mysqli_fetch_array($callingsavedaddress)) :
                        ?>
                                <label class="card">
                                    <!-- Address Cards -->
                                    <input name="address_id" class="radio" type="radio" value="<?= $add['address_id']; ?>" checked>
                                    <span class="plan-details">
                                        <span class="plan-type"><?= ($add['type'] == 0) ? "Office" : (($add['type'] == 1) ? "Home" : "Other"); ?></span>
                                        <span class="plan-cost">Name: <?= $add['alt_name'] . "<br>" . "Contact No: " . $add['alt_contact']; ?></span>
                                        <span><?= $add['house_no'] . "|" . $add['street'] . "-" . $add['area'] . "<br> Landmark: " . $add['landmark'] . "<br>" . "Pincode: " . $add['pincode'] . "<br>" . "City: " . $add['city'] . "<br>" . "State: " . $add['state']; ?></span>
                                        <a href="checkout.php?address_id=<?= $add['address_id']; ?>" class="badge bg-danger text-white text-decoration-none w-22 ms-auto">Delete</a>
                                    </span>
                                </label>
                            <?php endwhile; ?>
                            <div class="d-flex justify-content-between gap-3">
                                <a href="cart.php" class="btn btn-dark ">Go Back</a>
                                <input type="submit" class="btn btn-primary" name="make_payment" value="Proceed To Payment">
                            </div>
                </form>
            <?php else : ?>
                <h3 class="text-muted h5">Empty Saved Address</h3>
            <?php endif; ?>
            </div>
        </div>
    </div>


    <?php
    if (isset($_POST['save_address'])) {
        $alt_name = $_POST['alt_name'];
        $alt_contact = $_POST['alt_contact'];
        $type = $_POST['type'];
        $street = $_POST['street'];
        $pincode = $_POST['pincode'];
        $house_no = $_POST['house_no'];
        $area = $_POST['area'];
        $landmark = $_POST['landmark'];
        $city = $_POST['city'];
        $state = $_POST['state'];

        $user_id = $getuser['user_id'];

        $queryforinsertAddress = mysqli_query($connect, "INSERT INTO address(alt_name,alt_contact,type,street,pincode,house_no,area,landmark,city,state,user_id) value('$alt_name','$alt_contact','$type','$street','$pincode','$house_no','$area','$landmark','$city','$state','$user_id')");

        if ($queryforinsertAddress) {
            echo "<script>window.open('checkout.php','_self')</script>";
        } else {
            echo "<script>alert('Failed to save address')</script>";
        }
    }



    if (isset($_GET['address_id'])) {
        $id = $_GET['address_id'];
        $user_id = $getuser['user_id'];

        $queryForDeleteAddress = mysqli_query($connect, "DELETE FROM address WHERE address_id ='$id' AND user_id='$user_id'");

        if ($queryForDeleteAddress) {
            echo "<script>window.open('checkout.php','_self')</script>";
        } else {
            echo "<script>alert('failed to delete Address')</script>";
        }
    }

    if (isset($_POST['make_payment'])) {
        $address_id = $_POST['address_id'];
        $order_id = $myorder['order_id'];

        // Update this address in order record

        $queryForAddressUpdate = mysqli_query($connect, "UPDATE orders SET address_id = '$address_id' WHERE user_id='$user_id' AND order_id = '$order_id'");

        if ($queryForAddressUpdate) {
            echo "<script>window.open('make_payment.php','_self')</script>";
        } else {
            echo "<script>alert('Fail To Proceed!')</script>";
        }
    }
    ?>