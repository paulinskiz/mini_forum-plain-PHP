<?php
require_once ('../db_connect.php');
session_start();

if (!$_POST){
    header('location: ../');
    die();
}

$role = $_SESSION['role'];
$user = $_SESSION['id'];
$post_id = $_POST['post_id'];

// get info about the post from database:
try {
    $select = "SELECT * FROM posts WHERE id = '$post_id'";
    $query = $conn->prepare($select);
    $query->execute();
    $result = $query->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// check the privileges:
if ($result['user_id'] != $user && $role != 1) {
    header('location: ../');
    die();
}

// delete post comments likes from database:
try {
    $deleteCommLikes = "DELETE comm_likes FROM comm_likes JOIN comments ON comments.id = comm_likes.comment_id WHERE post_id = '$post_id'";
    $queryCommDelete = $conn->prepare($deleteCommLikes);
    $queryCommDelete->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// delete post comments from database:
try {
    $deleteComm = "DELETE FROM comments WHERE post_id = '$post_id'";
    $queryDelete = $conn->prepare($deleteComm);
    $queryDelete->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// delete post likes from database:
try {
    $deleteLikes = "DELETE FROM likes WHERE post_id = '$post_id'";
    $queryDeleteLikes = $conn->prepare($deleteLikes);
    $queryDeleteLikes->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// delete post from database:
try {
    $delete = "DELETE FROM posts WHERE id = '$post_id'";
    $query2 = $conn->prepare($delete);
    $query2->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

header('location: ../');



?>