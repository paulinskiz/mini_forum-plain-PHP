<?php
require_once '../db_connect.php';
session_start();

if (!$_POST) {
    header('location: ../');
    die();
}

$comment_id = $_POST['comment_id'];
$user_id = $_SESSION['id'];

try {
    $commentData = "SELECT * FROM comments WHERE id = $comment_id";
    $queryComm = $conn->prepare($commentData);
    $queryComm->execute();
    $commArray = $queryComm->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

try {
    $commLikesData = "SELECT * FROM comm_likes WHERE comment_id = $comment_id AND user_id = $user_id";
    $queryCommLikes = $conn->prepare($commLikesData);
    $queryCommLikes->execute();
    $commLikesArray = $queryCommLikes->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

if ($commLikesArray) {
    $unlike = "UPDATE comments SET likes = likes - 1 WHERE id = $comment_id";
    $queryUnlike = $conn->prepare($unlike);
    $queryUnlike->execute();
    $delete = "DELETE FROM comm_likes WHERE comment_id = '$comment_id' AND user_id = '$user_id'";
    $queryDelete = $conn->prepare($delete);
    $queryDelete->execute();
} else {
    $like = "UPDATE comments SET likes = likes + 1 WHERE id = $comment_id";
    $queryLike = $conn->prepare($like);
    $queryLike->execute();
    $insert = "INSERT INTO comm_likes (comment_id, user_id) VALUES ('$comment_id', '$user_id')";
    $queryInsert = $conn->prepare($insert);
    $queryInsert->execute();
}

header('location: ../');



?>