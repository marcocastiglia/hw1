<?php

session_start();
if(!isset($_SESSION['username'])){
    header("Location: ../log/startingpage.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "hw1");
$info = array();
$query = "SELECT count(*) as N_comm FROM comment WHERE username = '".$_SESSION['username']."'";
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($res)) {
    $info['comment'] = $row; 
}
mysqli_free_result($res);

$query = "SELECT count(*) as N_likes FROM likerecipe WHERE username = '".$_SESSION['username']."'";
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($res)) {
    $info['like'] = $row; 
}
mysqli_free_result($res);

$query = "SELECT nfavorite as N_fav FROM users WHERE username = '".$_SESSION['username']."'";
$res = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($res)) {
    $info['fav'] = $row; 
}
mysqli_free_result($res);

echo json_encode($info);
mysqli_close($conn);
?>