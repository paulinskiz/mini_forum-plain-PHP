<?php
require_once ('../db_connect.php');
session_start();

if (!$_POST){
    header('location: ../');
    die();
}

$id = $_SESSION['id'];
$password = $_POST['password'];

try {
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

$hash = $result['password'];

if (!password_verify($password, $hash)) {
    header('location: ../views/profile.php?error=deletePassword');
    die();
}

try {
    $allLikes = "SELECT post_id FROM likes WHERE user_id = '$id'";
    $allLikesSelect = $conn->prepare($allLikes);
    $allLikesSelect->execute();
    $likesArray = $allLikesSelect->fetchAll();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

foreach ($likesArray as $like) {
    $post_id = $like['post_id'];
    $unlike = "UPDATE posts SET likes = likes - 1 WHERE id = '$post_id'";
    $likesUpdate = $conn->prepare($unlike);
    $likesUpdate->execute();
}

try{
    $likes = "DELETE FROM likes WHERE user_id = $id";
    $likesDelete = $conn->prepare($likes);
    $likesDelete->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

try {
    $deleteComm = "DELETE FROM comments WHERE user_id = '$id'";
    $queryDelete = $conn->prepare($deleteComm);
    $queryDelete->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

try {
    $posts = "DELETE FROM posts WHERE user_id = $id";
    $postsDelete = $conn->prepare($posts);
    $postsDelete->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

try {
    $acc = "DELETE FROM users WHERE id = $id";
    $accDelete = $conn->prepare($acc);
    $accDelete->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

session_unset();
header('location: ../');


?>