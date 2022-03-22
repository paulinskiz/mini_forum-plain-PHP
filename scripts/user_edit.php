<?php
require_once ('../db_connect.php');

if (!$_POST){
    header('location: ../');
    die();
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$username = $_POST['username'];
$role_id = $_POST['role_id'];
$id = $_POST['id'];

// Updade user information to database:
try {
    $update = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username', email = '$email', role_id = '$role_id' WHERE id = '$id'";
    $query = $conn->prepare($update);
    $query->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

header('location: ../views/user_edit.php?userId='.$id.'&error=success');




?>