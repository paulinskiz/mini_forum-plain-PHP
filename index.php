<?php
include 'layouts/header.php';

if (isset($_SESSION['username'])) {
    header('location: views/main.php');
}

?>


<div class="container my-5">
    <div class="row justify-content-md-center">
        <div class="col col-lg-4">
            <img src="dist/img/pixel-cells.png" class="img-fluid" alt="">
        </div>
        <div class="col col-lg-6 position-relative">
            <div class="position-absolute top-50 start-50 translate-middle">
                <h1 class="text-success my-2">Welcome back!</h1>
                <a class="btn btn-success btn-lg my-2" role="button" href="views/login.php">Log in</a>
                <a class="btn btn-primary btn-lg my-2" role="button" href="views/register.php">Register</a>
            </div>    
        </div>
    </div>
</div>


<?php
include 'layouts/footer.php';
?>