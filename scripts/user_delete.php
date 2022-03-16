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