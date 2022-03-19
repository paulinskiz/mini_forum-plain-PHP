<?php
require_once ('../db_connect.php');
session_start();

if (!$_POST){
    header('location: ../');
    die();
}

$comment = $_POST['comment'];
$comment_id = $_POST['comment_id'];
$user = $_SESSION['username'];
$user_id = $_SESSION['id'];
$user_role = $_SESSION['role'];
$date = date('Y-m-d H:i:s');

try {
    $update = "UPDATE comments SET comment = '$comment', last_modified = '$date' WHERE id = '$comment_id'";
    $query = $conn->prepare($update);
    $query->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

header('location: ../');

?>