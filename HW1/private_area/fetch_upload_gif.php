<?php
session_start();
if(!isset($_SESSION["username"]))
{
    header("Location: ../log/startingpage.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "hw1");
$query = "UPDATE users SET pro_gif = '".$_POST['keyword']."' WHERE username = '".$_SESSION['username']."'";
mysqli_query($conn, $query);
mysqli_close($conn);  
?>