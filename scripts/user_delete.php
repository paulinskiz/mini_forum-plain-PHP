<?php
require_once '../db_connect.php';
session_start();

if (!$_POST) {
    header('location: ../');
    die();
}

$id = $_POST['id'];
$user = $_SESSION['username'];
$role = $_SESSION['role'];

// Check if user is admin:
if ($role != 1) {
    header('location: ../');
    die();
}

// Get all info from all tables of the user and edit tables:
// Get all liked posts:
try {
    $allLikes = "SELECT post_id FROM likes WHERE user_id = '$id'";
    $allLikesSelect = $conn->prepare($allLikes);
    $allLikesSelect->execute();
    $likesArray = $allLikesSelect->fetchAll();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// unlike all posts:
foreach ($likesArray as $like) {
    $post_id = $like['post_id'];
    $unlike = "UPDATE posts SET likes = likes - 1 WHERE id = '$post_id'";
    $likesUpdate = $conn->prepare($unlike);
    $likesUpdate->execute();
}

// delete likes from likes table:
try{
    $likes = "DELETE FROM likes WHERE user_id = $id";
    $likesDelete = $conn->prepare($likes);
    $likesDelete->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// Get all liked comments:
try {
    $allCommLikes = "SELECT comment_id FROM comm_likes WHERE user_id = '$id'";
    $allCommLikesSelect = $conn->prepare($allCommLikes);
    $allCommLikesSelect->execute();
    $commLikesArray = $allCommLikesSelect->fetchAll();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// unlike all comments:
foreach ($commLikesArray as $like) {
    $comment_id = $like['comment_id'];
    $unlikeComm = "UPDATE comments SET likes = likes - 1 WHERE id = '$comment_id'";
    $commLikesUpdate = $conn->prepare($unlikeComm);
    $commLikesUpdate->execute();
}

// delete comment likes from comm_likes table:
try{
    $commLikes = "DELETE FROM comm_likes WHERE user_id = $id";
    $commLikesDelete = $conn->prepare($commLikes);
    $commLikesDelete->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// delete comments:
try {
    $deleteComm = "DELETE FROM comments WHERE user_id = '$id'";
    $queryDelete = $conn->prepare($deleteComm);
    $queryDelete->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// Delete posts:
try {
    $posts = "DELETE FROM posts WHERE user_id = $id";
    $postsDelete = $conn->prepare($posts);
    $postsDelete->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// delete the user:
try {
    $delete = "DELETE FROM users WHERE id = '$id'";
    $query2 = $conn->prepare($delete);
    $query2->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// if deleted loged in user then logout:
if ($_SESSION == $id) {
    session_unset();
    header('location: ../');
} else {
    header('location: ../views/users.php');    
}

?>