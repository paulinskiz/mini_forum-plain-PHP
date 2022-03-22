<?php
require_once ('../db_connect.php');

if (!$_POST){
    header('location: ../');
    die();
}

$username = $_POST['username'];
$password = $_POST['password'];

// get information about the user from database:
try {
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// check if there is the user, is the password was correct and set the session:
if ($result) {
    session_start();
    $hash = $result["password"];
    if (password_verify($password, $hash)) {
        $_SESSION['username'] = $result['username'];
        $_SESSION['id'] = $result['id'];
        $_SESSION['role'] = $result['role_id'];
        header('location: ../views/main.php');
    } else {
        header("location: ../views/login.php?error=password&username=$username");
    }
} else {
    header("location: ../views/login.php?error=user&username=$username");;
}

?>