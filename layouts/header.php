<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../dist/style.css">
</head>
<body>
<!-- Top nav-bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-lg">
<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light"> -->
  <div class="container">
    <a class="navbar-brand" href="http://localhost/lecturePractice/mini_forum/">
        <i class="fa-solid fa-i-cursor"></i>
        Forum
        <i class="fa-solid fa-icons"></i>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <!-- nav bar -->
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-link <?php if(!isset($_SESSION['username'])){echo 'disabled';} ?>" href="../views/main.php">News feed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if(!isset($_SESSION['username'])){echo 'disabled';} ?>" href="../views/users.php">Users</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link <?php if(!isset($_SESSION['username'])){echo 'disabled';} ?>" href="#">Disabled</a>
            </li> -->
        </ul>
        
        <!-- Login bar -->
        <ul class="navbar-nav ms-auto">
            <?php 
                if (!isset($_SESSION['username'])) {
                    echo 
                    '<li class="nav-item">
                    <a class="nav-link" href="http://localhost/lecturePractice/mini_forum/views/register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/lecturePractice/mini_forum/views/login.php">Log in</a>
                    </li>';
                } else {
                    echo 
                    '<a class="navbar-brand" href="../views/profile.php">'.$_SESSION['username'].'</a>
                    <li class="nav-item">
                        <a class="nav-link" href="../scripts/logout.php">Log out</a>
                    </li>';
                }
            ?>

        </ul>
    </div>
  </div>
</nav>