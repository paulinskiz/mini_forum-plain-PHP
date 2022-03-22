<?php
include '../layouts/header.php';

// don't show welcome page without success registration:
if ($_GET['error']!='success') {
    header('location: ../');
    die();
}
?>

<!-- Welcome page for new registered user: -->
<div class="container my-5">
    <div class="row justify-content-md-center">
        <div class="col col-lg-4">
            <img src="../dist/img/achievement.png" class="img-fluid" alt="">
        </div>
        <div class="col col-lg-8 position-relative">
            <div class="position-absolute top-50 start-50 translate-middle">
                <h1 class="text-primary">Hoorayyy!!</h1>
                <h3 class="text-success">Welcome joined to our family!</h3>
                <h3 class="text-success">Now you can log in.</h3>
                <a class="btn btn-success btn-lg my-2" role="button" href="login.php">Log in</a>
            </div>    
        </div>
    </div>
</div>



<?php
include '../layouts/footer.php';
?>