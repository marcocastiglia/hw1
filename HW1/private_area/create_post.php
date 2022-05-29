<?php
    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("Location: ../log/startingpage.php");
        exit;
    }

    $conn = mysqli_connect("localhost", "root", "", "hw1");
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $textarea = mysqli_real_escape_string($conn, $_POST['textarea']);

    if(!isset($_POST['image_keyword']) && strpos($_POST['image_keyword'],"http://") === false && strpos($_POST['image_keyword'],"https://") === false) {
        $query = "INSERT INTO recipe(username,title,text) VALUES('".$_SESSION['username']."','".$title."','".$textarea."')";
    } else{
        $query = "INSERT INTO recipe(username,title,text,image) VALUES('".$_SESSION['username']."','".$title."','".$textarea."','".$_POST['image_keyword']."')";
    }
    if (mysqli_query($conn, $query)) {
        echo json_encode($info[] = 'TRUE');
    }
    else {
        echo json_encode($info[] = 'FALSE');
    }

    

    if(isset($_POST['ingredient'])) {
        $res = mysqli_query($conn, 'SELECT max(id) as max_id from recipe');
        $row = mysqli_fetch_assoc($res);
        for($i = 0; $i < count($_POST['ingredient']); $i++) {
            $query = "INSERT INTO ingredients VALUES('".mysqli_real_escape_string($conn,$_POST['ingredient'][$i])."','".$row['max_id']."')";
            mysqli_query($conn, $query);
        }
        mysqli_free_result($res);
    }
    mysqli_close($conn);   
?>