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
    if($_GET['type'] === 'fav') {
        $query = "INSERT INTO favoriterecipe VALUES('".$_SESSION['username']."',".$_GET['post'].")";
    }
    if($_GET['type'] === 'not_fav') {
        $query = "DELETE FROM favoriterecipe WHERE username = '".$_SESSION['username']."' AND recipe = ".$_GET['post'];
    }

    mysqli_query($conn, $query);
    mysqli_close($conn);  
}
?>