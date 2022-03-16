<?php
include '../layouts/header.php';
require_once '../db_connect.php';

if (!$_SESSION) {
    header('location: ../');
}
$username = $_SESSION['username'];

$sql = "SELECT * FROM users WHERE username = '$username'";
$query = $conn->prepare($sql);
$query->execute();
$result = $query->fetch();


?>

<div class="container my-5 py-5">
    <div class="row justify-content-md-around">
        <div class="col col-lg-5">
            <div class="">
                <h2 class="text-primary">Edit your profile:</h2>
                <form class="row g-2" action="../scripts/profile_edit.php" method="POST">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="first_name" value="<?php echo $result['first_name'] ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Surname:</label>
                        <input type="text" class="form-control" name="last_name" value="<?php echo $result['last_name'] ?>">
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $result['email'] ?>">
                    </div>
                    <div class="col-12">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $result['username'] ?>">
                    </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                    <?php
                    if (!empty($_GET)) {
                        if($_GET['error'] == 'password') {
                            echo '<span class="text-danger">Wrong password!</span>';
                        } elseif ($_GET['error'] == 'success'){
                            echo '<span class="text-success">Edit was successful!</span>';
                        }
                    }
                    ?>
                </form>
            </div>
        </div>
        <div class="col col-lg-5">
            <div class="">
                <h2 class="text-primary">Change password:</h2>
                <form class="row g-2" action="../scripts/password_change.php" method="POST">
                    <div class="row g-1">
                        <div class="col-md-6">
                            <label for="old_password" class="form-label">Old password:</label>
                            <input type="password" class="form-control" name="old_password">
                            <input type="hidden" name="id" value="<?php echo $result['id'] ?>">
                        </div>
                    </div>
                    <div class="row g-1">
                        <div class="col-md-6">
                            <label for="new_password" class="form-label">New password:</label>
                            <input type="password" class="form-control" name="new_password">
                        </div>
                        <div class="col-md-6">
                            <label for="new_password2" class="form-label">Repeat password:</label>
                            <input type="password" class="form-control" name="new_password2">
                        </div>
                    </div>
                    <div class="row g-1">
                        <div class="col-12">
                                <button type="submit" class="btn btn-primary">Change password</button>
                        </div>
                        <?php
                        if (!empty($_GET)) {
                            if ($_GET['error'] == 'newPassword') {
                                echo '<span class="text-danger">Password did not match!</span>';
                            } else if ($_GET['error'] == 'oldPassword') {
                                echo '<span class="text-danger">Wrong password!</span>';
                            } else if ($_GET['error'] == 'changed') {
                                echo '<span class="text-success">Password changed successfully!</span>';
                            }
                        }
                        ?>
                    </div>                 
                </form>
            </div>
            <div class="my-2">
                <h2 class="text-primary">Delete your account:</h2>
                <form class="row g-2" action="../scripts/account_delete.php" method="POST">
                    <div class="row g-1">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Enter password:</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="row g-1">
                        <div>
                            <input type="submit" value="Delete" class="btn btn-danger">
                        </div>
                        <?php
                        if (!empty($_GET)) {
                            if ($_GET['error'] == 'deletePassword') {
                                echo '<span class="text-danger">Wrong password!</span>';
                            }
                        }
                        ?>
                    </div>
                </form>
            </div>    
        </div>
    </div>
</div>


<?php
include '../layouts/footer.php';
?>