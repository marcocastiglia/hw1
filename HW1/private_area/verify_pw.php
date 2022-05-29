<?php
session_start();
if(!isset($_SESSION["username"]))
{
    header("Location: ../log/startingpage.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "hw1");
$query = "SELECT * FROM users WHERE username = '".$_SESSION['username']."' AND password = '".mysqli_real_escape_string($conn,$_POST['password'])."'";
$res = mysqli_query($conn, $query);
echo json_encode(mysqli_num_rows($res));

mysqli_free_result($res);
mysqli_close($conn);
?>