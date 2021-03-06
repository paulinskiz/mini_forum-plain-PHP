<?php
require_once ('../db_connect.php');

if(!$_POST){
    header('location: ../');
    die;
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

// Check if typed password is the same in two inputs:
if ($password != $password2) {
    header('location: ../views/register.php?error=password');
    die();
}

// encrypt the password:
$hash = password_hash($password, PASSWORD_BCRYPT);

// create a new user into database:
try {
    $sql = "INSERT INTO users(first_name, last_name, username, email, password) VALUES ('$first_name', '$last_name', '$username', '$email', '$hash')";
    $query = $conn->prepare($sql);
    $query->execute();
} catch(PDOException $e) {
    echo 'Registration failed: '.$e->getMessage();
}

header('location: ../views/welcome.php?error=success');

?>