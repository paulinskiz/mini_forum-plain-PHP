<?php
include '../layouts/header.php';
require_once '../db_connect.php';

if (!$_SESSION) {
    header('location: ../');
    die();
}

$select = "SELECT p.id, p.post, u.username, u.role_id FROM posts AS p LEFT JOIN users AS u ON u.id = p.user_id";
$query = $conn->prepare($select);
$query->execute();
$result = $query->fetchAll();

?>

<!-- Form for new post -->
<div class="container my-5 bg-secondary bg-opacity-25 px-5 py-3" style="border-radius: 10px 10px 0 0;">
    <div class="row justify-content-end">
        <form action="../scripts/post.php" method="POST" class="col col-8">
            <div class="form-floating col col-12">
            <textarea class="form-control d-inline" placeholder="Leave a comment here" name="post" style="height: 150px" maxlength="600"></textarea>
            <label for="floatingTextarea2">Say something:</label>
            </div>
            <div class="col col-12 d-flex flex-row-reverse">
            <input type="hidden" name="user" value="<?php echo $_SESSION['username']; ?>">
            <input type="submit" value="Create post" class="btn btn-success opacity-75">
            </div>
        </form>
        <div class="bg-primary bg-opacity-50 col col-2 p-3" style="border-radius: 0 10px 10px 0">
            <span><?php echo $_SESSION['username']; ?></span>
        </div>
    </div>
</div>
<div class="container my-5 bg-light px-5 py-3" style="border-radius: 0 0 10px 10px;">
    <?php 
        foreach (array_reverse($result) as $post) {
            echo '
            <div class="row justify-content-start my-2">
                <div class="bg-success bg-opacity-50 col col-2 p-3" style="border-radius: 10px 0 0 10px">
                    <span>'.$post['username'].'</span>
                </div>
                <div class="col col-7 mx-2 border border-start-0 border-3 border-secondary" style="border-radius: 0 10px 10px 0">
                    <p>'.$post['post'].'</p>
                </div>
                <div class="col col-2">
                ';
            if ($_SESSION['username'] == $post['username'] || $_SESSION['role'] == 1) {
                echo '
                <a href="post_edit.php?post_id='.$post['id'].'" class="btn btn-primary opacity-75">Edit</a>
                <form action="../scripts/post_delete.php" method="POST" class="d-inline-block">
                    <input type="hidden" name="post_id" value="'.$post['id'].'">
                    <input type="submit" value="Delete" class="btn btn-danger opacity-75">
                </form>
                ';
            }
            echo '
                </div>
            </div>
            ';
        }
    ?>
</div>


<?php
include '../layouts/footer.php';
?>