<?php

session_start();
if(!isset($_SESSION['username'])){
    header("Location: ../log/startingpage.php");
    exit;
}
if(!isset($_GET['recipe_id'])){
    header("Location: homepage.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "hw1");

$textarea = mysqli_real_escape_string($conn,$_POST['textarea']);

$query = "INSERT INTO comment(username,recipe,text) VALUES('".$_SESSION['username']."',".$_GET['recipe_id'].",'".$textarea."')";
mysqli_query($conn, $query);

$query = "SELECT count(*) as n_comments from comment where recipe = '".$_GET['recipe_id']."'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $query));
echo json_encode(array('quantity' => $row,'recipe_id' => $_GET['recipe_id']));
mysqli_close($conn);


?>