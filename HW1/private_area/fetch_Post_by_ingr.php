<?php

session_start();
if(!isset($_SESSION['username'])){
    header("Location: ../log/startingpage.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "hw1");
$recipes = array();
$ingredients = array();
$likes = array();
$favorites = array();

$query = "SELECT * FROM recipe where id in (SELECT recipe from ingredients where name = '".$_POST['ingredient']."') ORDER BY id DESC"; 

$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($res)) {
    $recipes[] = $row; 
}
mysqli_free_result($res);

$query = "SELECT * from ingredients where recipe in 
            (SELECT id FROM recipe where id in 
            (SELECT recipe from ingredients where name = '".$_POST['ingredient']."'))";

$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($res)) {
    $ingredients[] = $row; 
}
mysqli_free_result($res);

$query = "SELECT * FROM likerecipe WHERE username='".$_SESSION['username']."'";

$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($res)) {
    $likes[] = $row; 
}
mysqli_free_result($res);

$query = "SELECT * FROM favoriterecipe WHERE username='".$_SESSION['username']."'";
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($res)) {
    $favorites[] = $row; 
}
mysqli_free_result($res);

$post = array('recipes' => $recipes, 'ingredients' => $ingredients, 'likes' => $likes, 'favorites' => $favorites);
echo json_encode($post);


mysqli_close($conn);
?>