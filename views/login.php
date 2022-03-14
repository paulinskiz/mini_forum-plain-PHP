<?php
include '../layouts/header.php';

if (isset($_SESSION['username'])) {
    header('location: main.php');
}
?>

<div class="container my-5">
    <div class="row justify-content-md-center">
        <div class="col col-lg-4">
            <img src="../dist/img/cyber-security.png" class="img-fluid" alt="">
        </div>
        <div class="col col-lg-6 position-relative">
            <div class="position-absolute top-50 start-50 translate-middle">
                <form action="../scripts/login.php" method="POST">
                    <h2 class="text-primary">Log in!</h2>
                    <label for="username" class="col-sm-2 col-form-label">Username:</label>
                    <input type="text" class="form-control my-1" name="username" value="<?php 
                        if (!empty($_GET['username'])) {
                            echo $_GET['username'];
                        } ?>">
                    <label for="password" class="col-sm-2 col-form-label">Password:</label>
                    <input type="password" class="form-control my-1" name="password">
                    <button type="submit" class="btn btn-primary my-3">Log in</button>
                    <?php
                        if (!empty($_GET)) {
                            if ($_GET['error'] == 'user') {
                                echo '<span class="text-danger">This user is not registered!</span>';
                            } elseif ($_GET['error'] == 'password') {
                                echo '<span class="text-danger">Wrong password!</span>';
                            }
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