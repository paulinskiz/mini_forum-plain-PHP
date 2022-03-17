<?php
require_once ('../db_connect.php');
session_start();

if (!$_POST){
    header('location: ../');
    die();
}

$id = $_SESSION['id'];
$post_id = $_POST['post_id'];
$comment = $_POST['comment'];

// Insert comment into database:
try {
    $comment = "INSERT INTO comments (comment, post_id, user_id) VALUES ('$comment', '$post_id', '$id')";
    $queryComment = $conn->prepare($comment);
    $queryComment->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

header('location: ../');





?>