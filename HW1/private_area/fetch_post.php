<?php

session_start();
if(!isset($_SESSION['username'])){
    header("Location: ../log/startingpage.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "hw1");
$recipes = array();
$ingredients = array();
$query = "SELECT * FROM recipe WHERE username = '".$_SESSION['username']."' ORDER BY id DESC";
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($res)) {
    $recipes[] = $row; 
}

mysqli_free_result($res);

$query = "SELECT * FROM ingredients WHERE recipe in (SELECT id from recipe where username = '".$_SESSION['username']."')";
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($res)) {
    $ingredients[] = $row; 
}
$post = array('recipes' => $recipes, 'ingredients' => $ingredients);
echo json_encode($post);
mysqli_free_result($res);

mysqli_close($conn);


?>