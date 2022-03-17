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

try {
    $select = "SELECT * FROM posts WHERE id = '$post_id'";
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
    $deleteComm = "DELETE FROM comments WHERE post_id = '$post_id'";
    $queryDelete = $conn->prepare($deleteComm);
    $queryDelete->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

try {
    $delete = "DELETE FROM posts WHERE id = '$post_id'";
    $query2 = $conn->prepare($delete);
    $query2->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

header('location: ../');



?>