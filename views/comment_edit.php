<?php
include '../layouts/header.php';
require_once '../db_connect.php';

if (!$_SESSION) {
    header('location: ../');
    die();
}

$comment_id = $_GET['comment_id'];
$user = $_SESSION['username'];
$user_id = $_SESSION['id'];
$user_role = $_SESSION['role'];


// $userSql = "SELECT * FROM posts WHERE post_id = '$post_id'";

// get the information about post and user from database:
try {
    $select = "SELECT c.id, c.comment, u.username FROM comments AS c LEFT JOIN users AS u ON u.id = c.user_id HAVING c.id = '$comment_id'";
    $query = $conn->prepare($select);
    $query->execute();
    $result = $query->fetch();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// check the privileges:
if ($result['username'] != $user && $user_role != 1) {
    header('location: ../');
    die();
}

$comment = $result['comment'];

?>

<!-- form for comment edit with comment information: -->
<div class="container my-5 bg-secondary bg-opacity-25 px-5 py-3" style="border-radius: 10px 10px 0 0;">
    <div class="row justify-content-end">
        <form action="../scripts/comment_edit.php" method="POST" class="col col-8">
            <div class="form-floating col col-12">
                <textarea class="form-control d-inline" placeholder="Leave a comment here" name="comment" style="height: 100px" maxlength="500"><?php echo $comment ?></textarea>
                <label for="floatingTextarea2">Comment:</label>
            </div>
            <div class="col col-12 d-flex flex-row-reverse">
                <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
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