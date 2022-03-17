<?php
include '../layouts/header.php';
require_once '../db_connect.php';

if (!$_SESSION) {
    header('location: ../');
    die();
}

$id = $_POST['id'];
$user = $_SESSION['username'];

try {
    $userSql = "SELECT * FROM users WHERE username = '$user'";
    $query = $conn->prepare($userSql);
    $query->execute();
    $result = $query->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

$role_id = $result['role_id'];

if ($role_id != 1) {
    header('location: ../');
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
    $delete = "DELETE FROM users WHERE id = '$id'";
    $query2 = $conn->prepare($delete);
    $query2->execute();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

header('location: ../views/users.php');



?>
<?php
include '../layouts/footer.php';
?>