<?php
require_once ('../db_connect.php');
session_start();

if (!$_POST){
    header('location: ../');
    die();
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$id = $_POST['id'];

try {
    $sql = "SELECT * FROM users WHERE id = $id";
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

$hash = $result['password'];
if (!password_verify($password, $hash)) {
    header('location: ../views/profile.php?error=password');
    die();
}

try {
    $edit = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username', email = '$email' WHERE id = $id";
    $query2 = $conn->prepare($edit);
    $test = $query2->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

$_SESSION['username'] = "$username";

header('location: ../views/profile.php?error=success');




?>