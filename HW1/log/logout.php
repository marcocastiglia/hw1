<?php
    session_start();
    session_destroy();
    header("Location: startingpage.php");
    exit;
?>