<?php
include '../layouts/header.php';
require_once '../db_connect.php';

if (!$_SESSION) {
    header('location: ../');
    die();
}

$id = $_GET['userId'];

// check the privileges:
$role_id = $_SESSION['role'];

if ($role_id != 1) {
    header('location: ../');
    die();
}

// get the information about user from database:
try {
    $select = "SELECT * FROM users WHERE id = '$id'";
    $query2 = $conn->prepare($select);
    $query2->execute();
    $userData = $query2->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

$dataId = $userData['id'];
$first_name = $userData['first_name'];
$last_name = $userData['last_name'];
$username = $userData['username'];
$email = $userData['email'];
$role_id = $userData['role_id'];

?>

<!-- form for user edit with user information: -->
<div class="container my-5 py-5">
    <div class="row justify-content-md-around">
        <div class="col col-lg-5">
            <div class="">
                <h2 class="text-primary">Users "<?php echo $username; ?>" profile edit:</h2>
                <form class="row g-2" action="../scripts/user_edit.php" method="POST">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="first_name" value="<?php echo $first_name; ?>" require>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Surname:</label>
                        <input type="text" class="form-control" name="last_name" value="<?php echo $last_name; ?>" require>
                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" require>
                    </div>
                    <div class="col-12">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" require>
                    </div>
                        <div class="col-md-5">
                            <label for="role_id" class="form-label">Role number:</label>
                            <select class="form-select" aria-label="Default select example" name="role_id" require>
                                <option selected>Select role number</option>
                                <option value="1" <?php if ($role_id == 1) {echo 'selected';} ?>>1</option>
                                <option value="2" <?php if ($role_id == 2) {echo 'selected';} ?>>2</option>
                            </select>
                        </div>
                    
                    <input type="hidden" name="id" value="<?php echo $dataId; ?>">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                    <?php
                        if (!empty($_GET['error'])) {
                            if ($_GET['error'] == 'success') {
                                echo '<span class="text-success">Profile changed succesfully!</span>';
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