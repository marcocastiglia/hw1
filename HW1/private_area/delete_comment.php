<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: ../log/startingpage.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "hw1");
$query = "DELETE from comment where id = '".$_POST['comm_id']."'";
mysqli_query($conn, $query);
$query = "SELECT count(*) as n_comments from comment where recipe = '".$_POST['recipe_id']."'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $query));
echo json_encode(array('quantity' => $row,'recipe_id' => $_POST['recipe_id']));
mysqli_close($conn);
?>