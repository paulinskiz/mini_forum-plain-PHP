<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "forum";

// create a connection to database:
try {
    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'CONNECTED';
} catch(PDOException $e){
    echo 'Failed to connect: '.$e->getMessage();
}
?>