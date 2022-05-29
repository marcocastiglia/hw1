<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: ../log/startingpage.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "hw1");
$query = "DELETE from recipe where id = '".$_POST['id']."'";
if(mysqli_query($conn, $query)) {
    echo 'Cancellato.';
}
mysqli_close($conn);

?>