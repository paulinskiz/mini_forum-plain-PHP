<?php
require_once ('../db_connect.php');
session_start();

if (!$_POST){
    header('location: ../');
    die();
}

$id = $_SESSION['id'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE id = '$id'";
$query = $conn->prepare($sql);
$query->execute();
$result = $query->fetch();

$hash = $result['password'];

if (!password_verify($password, $hash)) {
    header('location: ../views/profile.php?error=deletePassword');
    die();
}

$allLikes = "SELECT post_id FROM likes WHERE user_id = '$id'";
$allLikesSelect = $conn->prepare($allLikes);
$allLikesSelect->execute();
$likesArray = $allLikesSelect->fetchAll();

foreach ($likesArray as $like) {
    $post_id = $like['post_id'];
    $unlike = "UPDATE posts SET likes = likes - 1 WHERE id = '$post_id'";
    $likesUpdate = $conn->prepare($unlike);
    $likesUpdate->execute();
}

$likes = "DELETE FROM likes WHERE user_id = $id";
$likesDelete = $conn->prepare($likes);
$likesDelete->execute();

$posts = "DELETE FROM posts WHERE user_id = $id";
$postsDelete = $conn->prepare($posts);
$postsDelete->execute();

$acc = "DELETE FROM users WHERE id = $id";
$accDelete = $conn->prepare($acc);
$accDelete->execute();


session_unset();
header('location: ../');


?>