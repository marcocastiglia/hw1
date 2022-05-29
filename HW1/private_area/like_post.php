<?php
session_start();
if(!isset($_SESSION["username"]))
{
    header("Location: ../log/startingpage.php");
    exit;
}

if(!isset($_GET['type']) || !isset($_GET['post'])) {
    header("Location: homepage.php");
    exit;
} else {
    $conn = mysqli_connect("localhost", "root", "", "hw1");
    if($_GET['type'] === 'like') {
        $query = "INSERT INTO likerecipe VALUES('".$_SESSION['username']."',".$_GET['post'].")";
    }
    if($_GET['type'] === 'dislike') {
        $query = "DELETE FROM likerecipe WHERE username = '".$_SESSION['username']."' AND recipe = ".$_GET['post'];
    }
    mysqli_query($conn, $query);

    $query = "SELECT count(*) as n_likes FROM likerecipe WHERE recipe = ".$_GET['post'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, $query));
    echo json_encode(array('quantity' => $row, 'post_id' => $_GET['post']));
    mysqli_close($conn);  
}
?>