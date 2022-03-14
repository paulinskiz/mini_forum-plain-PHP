<?php
require_once ('../db_connect.php');
session_start();

if (!$_POST){
    header('location: ../');
    die();
}

$user = $_POST['user'];
$post = $_POST['post'];
$userId = $_SESSION['id'];

if ($_SESSION['username'] != $user) {
    header('location: ../');
    die();
}

$insert = "INSERT INTO posts (user_id, post) VALUES ('$userId', '$post')";
$query = $conn->prepare($insert);
$query->execute();

header('location: ../');




?>