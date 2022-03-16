<?php
include '../layouts/header.php';
require_once '../db_connect.php';

if (!$_SESSION) {
    header('location: ../');
    die();
}

try {
    $post_id = $_GET['post_id'];
    $user = $_SESSION['username'];
    $user_id = $_SESSION['id'];
    $user_role = $_SESSION['role'];
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// $userSql = "SELECT * FROM posts WHERE post_id = '$post_id'";

$select = "SELECT p.id, p.post, u.username FROM posts AS p LEFT JOIN users AS u ON u.id = p.user_id HAVING p.id = '$post_id'";
$query = $conn->prepare($select);
$query->execute();
$result = $query->fetch();


if ($result['username'] != $user && $user_role != 1) {
    header('location: ../');
    die();
}

$post = $result['post'];

?>


<div class="container my-5 bg-secondary bg-opacity-25 px-5 py-3" style="border-radius: 10px 10px 0 0;">
    <div class="row justify-content-end">
        <form action="../scripts/post_edit.php" method="POST" class="col col-8">
            <div class="form-floating col col-12">
            <textarea class="form-control d-inline" placeholder="Leave a comment here" name="post" style="height: 150px" maxlength="600"><?php echo $post ?></textarea>
            <label for="floatingTextarea2">Say something:</label>
            </div>
            <div class="col col-12 d-flex flex-row-reverse">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="submit" value="Edit post" class="btn btn-success opacity-75">
            </div>
        </form>
        <div class="bg-primary bg-opacity-50 col col-2 p-3" style="border-radius: 0 10px 10px 0">
            <span><?php echo $result['username']; ?></span>
        </div>
    </div>
</div>



<?php
include '../layouts/footer.php';
?>