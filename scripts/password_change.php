<?php
require_once ('../db_connect.php');

if (!$_POST){
    header('location: ../');
    die();
}

// $username = $_SESSION['username'];
$id = $_POST['id'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];
$new_password2 = $_POST['new_password2'];

try {
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

$hash = $result['password'];

if (!password_verify($old_password, $hash)) {
    header('location: ../views/profile.php?error=oldPassword');
    die();
}

if ($new_password != $new_password2) {
    header('location: ../views/profile.php?error=newPassword');
    die();
}

$newHash = password_hash($new_password, PASSWORD_BCRYPT);

try {
    $update = "UPDATE users SET password = '$newHash' WHERE id = '$id'";
    $query2 = $conn->prepare($update);
    $query2->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

header('location: ../views/profile.php?error=changed');


?>