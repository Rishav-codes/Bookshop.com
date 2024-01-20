<?php include_once "connect.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<?php include_once "header.php"; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-5 mx-auto">
            <div class="card">
                <div class="card-header"><h2>Login Here</h2></div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="">Password</label>
                            <input type="password" name="password" class="form-control"required>
                        </div>
                        <div class="mb-3">
                            <input type="submit" name="login" value="Signin" class="btn btn-success w-100">
                        </div>
                    </form>
                    <?php
                    if(isset($_POST['login'])){
                        $email = $_POST['email'];
                        $password = md5($_POST['password']);

                        $query = mysqli_query($connect,"SELECT * FROM accounts where email='$email' AND password='$password'");

                        $count = mysqli_num_rows($query);
                        $check = mysqli_fetch_array($query);

                        if($count > 0){

                            $_SESSION['account'] = $email;

                            if($check['isAdmin'] == 1){
                                $_SESSION['admin'] = $email;
                                echo "<script>window.open('admin/index.php','_self')</script>";
                            }
                            else{
                                echo "<script>window.open('index.php','_self')</script>";
                            }
                        }
                        else{
                            echo "<script>alert('Invalid Email or Password')</script>";
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