<?php
require_once ('../db_connect.php');
session_start();

if (!$_POST){
    header('location: ../');
    die();
}

$post = $_POST['post'];
$post_id = $_POST['post_id'];
$user = $_SESSION['username'];
$user_id = $_SESSION['id'];
$user_role = $_SESSION['role'];
$date = date('Y-m-d H:i:s');

// update the post to database:
try {
    $update = "UPDATE posts SET post = '$post', last_modified = '$date' WHERE id = '$post_id'";
    $query = $conn->prepare($update);
    $query->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

header('location: ../');

?>