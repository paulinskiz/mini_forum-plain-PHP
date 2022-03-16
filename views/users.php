<?php
include '../layouts/header.php';
require_once '../db_connect.php';

if (!$_SESSION) {
    header('location: ../');
}

$username = $_SESSION['username'];

try {
    $getRole = "SELECT role_id FROM users WHERE username = '$username'";
    $query2 = $conn->prepare($getRole);
    $query2->execute();
    $role = $query2->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

$roleId = $role['role_id'];

try {
    $sql = "SELECT * FROM users";
    $query = $conn->prepare($sql);
    $query->execute();

    $result = $query->fetchAll();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}


?>

<div class="container my-5">
    <table class="table caption-top align-middle">
        <caption>List of users:</caption>
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Username</th>
                <th scope="col">First name</th>
                <th scope="col">Email</th>
                <th scope="col">Created</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($result as $user) {
                echo
                '<tr><th scope="row">'.$user['id'].'</th><td>'.$user['username'].'</td><td>'.$user['first_name'].'</td><td>'.$user['email'].'</td><td>'.$user['created'].'</td><td>';
                if ($_SESSION['role'] == 1) {
                    echo '<a href="user_edit.php?userId='.$user['id'].'" class="btn btn-primary mx-1">EDIT</a><form action="../scripts/user_delete.php" method="POST" class="d-inline mx-1"><input type="hidden" name="id" value="'.$user['id'].'"><input type="submit" class="btn btn-danger" value="DELETE"></form>';
                }
                echo '</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>







<?php


include '../layouts/footer.php';
?>