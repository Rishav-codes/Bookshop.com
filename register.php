<?php include_once "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <?php include_once "header.php"; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-5 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h2>Create an Account?</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="">Contact</label>
                                <input type="tel" name="contact" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <input type="submit" name="create" value="Signup" class="btn btn-primary w-100">
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['create'])) {
                            $name = $_POST['name'];
                            $contact = $_POST['contact'];
                            $email = $_POST['email'];
                            $password = md5($_POST['password']);

                            $query = mysqli_query($connect, "INSERT INTO accounts(name,contact,email,password) value('$name','$contact','$email','$password')");

                            if ($query) {
                                echo "<script>window.open('login.php','_self')</script>";
                            } else {
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