<?php
include '../layouts/header.php';
require_once '../db_connect.php';

// don't show main page for not logged in users:
if (!$_SESSION) {
    header('location: ../');
    die();
}

$user = $_SESSION['id'];

// Get post information from database:
try {
    $select = "SELECT p.id, p.post, p.created, p.last_modified, p.likes, u.username, u.role_id FROM posts AS p LEFT JOIN users AS u ON u.id = p.user_id";
    $query = $conn->prepare($select);
    $query->execute();
    $result = $query->fetchAll();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// Get logged in user likes information from database:
try {
    $likes = "SELECT * FROM likes WHERE user_id = '$user'";
    $queryLikes = $conn->prepare($likes);
    $queryLikes->execute();
    $likesArray = $queryLikes->fetchAll();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// Get comments information from database:
try {
    $comments = "SELECT c.id, c.comment, c.post_id, c.created, c.last_modified, c.likes, u.username FROM comments c LEFT JOIN posts p ON p.id = c.post_id LEFT JOIN users u ON u.id = c.user_id";
    $queryComments = $conn->prepare($comments);
    $queryComments->execute();
    $commentsArray = $queryComments->fetchAll();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}

// Get logged in user liked comments information from database:
try {
    $commLikes = "SELECT * FROM comm_likes WHERE user_id = $user";
    $queryCommLikes = $conn->prepare($commLikes);
    $queryCommLikes->execute();
    $commLikesArray = $queryCommLikes->fetchAll();
} catch (PDOException $e) {
    echo 'Error!! --- '.$e->getMessage();
}


?>

<!-- Form for new post -->
<div class="container my-5 bg-secondary bg-opacity-25 px-5 py-3" style="border-radius: 15px;">
    <div class="row justify-content-end">
        <form action="../scripts/post.php" method="POST" class="col col-8">
            <div class="form-floating col col-12">
            <textarea class="form-control d-inline" placeholder="Leave a comment here" name="post" style="height: 150px; border-radius: 10px 0 0 10px;" maxlength="600"></textarea>
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

    <!-- All posts posted in the forum -->
    <div class="container my-5 bg-light px-5 py-3" style="border-radius: 10px;">
        <?php 
            foreach (array_reverse($result) as $post) {
                echo '
                <div class="row justify-content-start mt-2">
                    <div class="bg-success bg-opacity-50 col col-2 p-3" style="border-radius: 10px 0 0 10px">
                        <span class="row">'.$post['username'].'</span>
                        <span class="row">'.$post['created'].'</span>';
                        if ($post['last_modified'] != $post['created']) {
                            echo '<span class="row" style="font-size: 10px;">Edited: '.$post['last_modified'].'</span>';
                        }
                    echo '
                    </div>
                    <div class="col col-7 mx-2 border-top border-end border-3 border-secondary" style="border-radius: 0 10px 0 0">
                        <p>'.$post['post'].'</p>
                    </div>
                    <div class="col col-2">
                        <div class="row">
                            <div>
                                <form action="../scripts/like.php" method="POST" class="d-inline">
                                    <input type="hidden" name="post_id" value="'.$post['id'].'">
                                    <button type="submit" class="btn btn-info my-1" >';
                                    $temp = 0;
                                    foreach ($likesArray as $like) {
                                        if ($like['post_id'] == $post['id'] && $like['user_id'] == $user) {
                                            $temp = 1;
                                        }
                                    }
                                    if ($temp == 1) {
                                        echo '<i class="fa-solid fa-heart-crack"></i>';
                                    } else {
                                        echo '<i class="fa-solid fa-heart"></i>';
                                    }
                                    echo ' ('.$post['likes'].')</button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div>';
                                if ($_SESSION['username'] == $post['username'] || $_SESSION['role'] == 1) {
                                    echo '
                                    <a href="post_edit.php?post_id='.$post['id'].'" class="btn btn-primary opacity-75">Edit</a>
                                    <form action="../scripts/post_delete.php" method="POST" class="d-inline">
                                        <input type="hidden" name="post_id" value="'.$post['id'].'">
                                        <input type="submit" value="Delete" class="btn btn-danger opacity-75">
                                    </form>
                                    ';
                                }
                                echo '
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-9 mt-1">';
                    foreach ($commentsArray as $comment) {
                        if ($comment['post_id'] == $post['id']) {
                            $created = $comment['created'];
                            $sec = strtotime($created);
                            $newCreated = date ("y/d/m H:i", $sec);
                            echo '
                            <div class="row border-top border-end my-1 pt-1">
                                <div class="col-3 border-end ps-5">
                                    <span class="row">'.
                                    $comment['username'].'
                                    </span>
                                    <span class="row">'.
                                    $newCreated.'
                                    </span>';
                                    if ($comment['created'] != $comment['last_modified']) {
                                        $last_modified = $comment['last_modified'];
                                        $sec = strtotime($last_modified);
                                        $newModified = date ("y/d/m H:i", $sec);
                                        echo '<span class="row" style="font-size: 10px;">Edited: '.$newModified.'</span>';
                                    }
                                    echo '
                                </div>                               
                                <div class="col-auto">'.
                                    $comment['comment'].'
                                </div>
                                <div class="col-auto">
                                    <div class="d-inline">
                                        <form action="../scripts/comment_like.php" method="POST" class="d-inline">
                                            <input type="hidden" name="comment_id" value="'.$comment['id'].'">
                                            <button type="submit" class="btn btn-sm btn-info">';
                                            $temp2 = 0;
                                            foreach ($commLikesArray as $like) {
                                                if ($like['comment_id'] == $comment['id'] && $like['user_id'] == $user) {
                                                    $temp2 = 1;
                                                }
                                            }
                                            if ($temp2 == 1) {
                                                echo '<i class="fa-solid fa-heart-crack"></i>';
                                            } else {
                                                echo '<i class="fa-solid fa-heart"></i>';
                                            }
                                            echo ' ('.$comment['likes'].')</button>
                                        </form>
                                    </div>';
                                    if ($_SESSION['username'] == $comment['username'] || $_SESSION['role'] == 1) {
                                        echo '
                                        <div class="d-inline">
                                            <a href="comment_edit.php?comment_id='.$comment['id'].'" class="btn btn-sm btn-primary opacity-75">Edit</a>
                                        </div>
                                        <div class="d-inline-block">
                                            <form action="../scripts/comment_delete.php" method="POST" class="d-inline">
                                                <input type="hidden" name="comment_id" value="'.$comment['id'].'">
                                                <input type="submit" value="Delete" class="btn btn-sm btn-danger opacity-75">
                                            </form>
                                        </div>';
                                    };
                                echo '
                                </div>
                            </div>';
                        }
                    }
                    echo '
                    <div class="row justify-content-start py-2 border border-top-0 border-1 border-secondary" style="border-radius: 0 0 10px 10px">
                        <form action="../scripts/comment.php" method="POST">
                            <div class="row align-items-center mx-1">
                                <div class="col-auto">
                                    <label for="comment" class="col-form-label">Leave a comment:</label>
                                </div>
                                <div class="col-7">
                                    <input type="text" name="comment" class="form-control" maxlength="500">
                                    <input type="hidden" name="post_id" value="'.$post['id'].'">
                                </div>
                                <div class="col-auto">
                                    <input type="submit" value="Enter" class="form-control btn-sm btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>';
            }
        ?>
    </div>
</div>

<?php
include '../layouts/footer.php';
?>