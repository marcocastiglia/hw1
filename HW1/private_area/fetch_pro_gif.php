<?php

session_start();
if(!isset($_SESSION['username'])){
    header("Location: ../log/startingpage.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "hw1");
$info = array();
$query = "SELECT pro_gif FROM users WHERE username = '".$_SESSION['username']."'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $query));
echo json_encode($row);
mysqli_close($conn);
?>