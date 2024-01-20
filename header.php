<nav class="navbar navbar-expand-lg navbar-light bg-success">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php">
            <span class="logo-text text-light">
                <h3><b>Bookshop</b></h3>
            </span>
        </a>

        <!-- Toggler for Mobile -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>



        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php
                if (isset($_SESSION['account'])) :
                    $email = $_SESSION['account'];
                    $getuser = mysqli_query($connect, "SELECT * FROM accounts WHERE email = '$email'");

                    $getuser = mysqli_fetch_array($getuser);
                ?>
                    <li class="nav-item active">
                        <a class="nav-link text-capitalize text-white" href="index.php">Welcome <?= $getuser['name']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light " href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light " href="cart.php">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light " href="my_order.php">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="logout.php">Logout</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link active text-light" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-light" href="register.php">Create an Account</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Second Navbar with Dropdown Menu -->
<div class="navbar navbar-expand-lg bg-light border-bottom">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav flex-wrap">
                <!-- All Departments Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown button
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                        <?php
                        $query = mysqli_query($connect, "SELECT * FROM categories");
                        while ($row = mysqli_fetch_array($query)) :
                        ?>
                            <li><a class="dropdown-item" href="index.php?cat_id=<?= $row['cat_id']; ?>"><?= $row['cat_title']; ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </div>

                <!-- Home Dropdown -->
                <li class="nav-item dropdown">
                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">Home</button>
                    <div class="dropdown-menu">
                        <a href="#get-help-link" class="dropdown-item">Get Help</a>
                        <a href="#wiki-faq-link" class="dropdown-item">Wiki & FAQ</a>
                        <a href="#translations-link" class="dropdown-item">Translations</a>
                    </div>
                </li>

                <!-- Add more dropdowns as needed -->

                <!-- Docs Link -->
                <li class="nav-item">
                    <a href="#docs-link" class="nav-link nav-item text-dark">Docs</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>