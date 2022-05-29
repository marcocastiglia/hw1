<?php

session_start();
if(!isset($_SESSION['username'])){
    header("Location: ../log/startingpage.php");
    exit;
}
if(!isset($_GET['post'])) {
    header("Location: homepage.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "hw1");
$comments = array();
$query = "SELECT * FROM comment WHERE recipe = '".$_GET['post']."' ORDER BY id DESC";
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($res)) {
    $comments[] = $row; 
}
$info = array('username' => $_SESSION['username'], 'comments' => $comments);
echo json_encode($info);
mysqli_free_result($res);
mysqli_close($conn);
?>