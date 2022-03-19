<?php
require_once ('../db_connect.php');
session_start();

if (!$_POST){
    header('location: ../');
    die();
}

$role = $_SESSION['role'];
$user = $_SESSION['id'];
$comment_id = $_POST['comment_id'];

try {
    $select = "SELECT * FROM comments WHERE id = '$comment_id'";
    $query = $conn->prepare($select);
    $query->execute();
    $result = $query->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

if ($result['user_id'] != $user && $role != 1) {
    header('location: ../');
    die();
}

try {
    $deleteCommLikes = "DELETE FROM comm_likes WHERE comment_id = '$comment_id'";
    $queryDelete = $conn->prepare($deleteCommLikes);
    $queryDelete->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

try {
    $delete = "DELETE FROM comments WHERE id = '$comment_id'";
    $query2 = $conn->prepare($delete);
    $query2->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

header('location: ../');



?>