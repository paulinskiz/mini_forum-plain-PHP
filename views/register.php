<?php
include '../layouts/header.php';

// don't show the register page for logged in users:
if (isset($_SESSION['username'])) {
    header('location: main.php');
}
?>

<!-- register form -->
<div class="container my-5">
    <div class="row justify-content-md-center">
        <div class="col col-lg-4">
            <img src="../dist/img/cyber-security.png" class="img-fluid" alt="">
        </div>
        <div class="col col-lg-8 position-relative">
            <div class="position-absolute top-50 start-50 translate-middle">
                <h2 class="text-primary">Registration form:</h2>
                <form class="row g-2" action="../scripts/register.php" method="POST">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="first_name">
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Surname:</label>
                        <input type="text" class="form-control" name="last_name">
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="col-12">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" name="username">
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="col-md-6">
                        <label for="password2" class="form-label">Repeat password:</label>
                        <input type="password" class="form-control" name="password2">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                    <?php
                        if (!empty($_GET) && $_GET['error'] == 'password') {
                            echo '<span class="text-danger">Password did not match!</span>';
                        }
                    ?>
                </form>
            </div>    
        </div>
    </div>
</div>


<?php
include '../layouts/footer.php';
?>