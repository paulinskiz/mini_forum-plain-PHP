<?php
include '../layouts/header.php';
require_once '../db_connect.php';

if (!$_SESSION) {
    header('location: ../');
    die();
}

$post_id = $_POST['post_id'];
$user_id = $_SESSION['id'];

try {
    $postData = "SELECT * FROM posts WHERE id = $post_id";
    $queryPost = $conn->prepare($postData);
    $queryPost->execute();
    $postArray = $queryPost->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

try {
    $likesData = "SELECT * FROM likes WHERE post_id = $post_id AND user_id = $user_id";
    $queryLikes = $conn->prepare($likesData);
    $queryLikes->execute();
    $likesArray = $queryLikes->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

if ($likesArray) {
    $minus = $postArray['likes'] - 1;
    $unlike = "UPDATE posts SET likes = '$minus' WHERE id = $post_id";
    $queryUnlike = $conn->prepare($unlike);
    $queryUnlike->execute();
    $delete = "DELETE FROM likes WHERE post_id = '$post_id' AND user_id = '$user_id'";
    $queryDelete = $conn->prepare($delete);
    $queryDelete->execute();
} else {
    $plus = $postArray['likes'] + 1;
    $like = "UPDATE posts SET likes = '$plus' WHERE id = $post_id";
    $queryLike = $conn->prepare($like);
    $queryLike->execute();
    $insert = "INSERT INTO likes (post_id, user_id) VALUES ('$post_id', '$user_id')";
    $queryInsert = $conn->prepare($insert);
    $queryInsert->execute();
}

header('location: ../');



?>