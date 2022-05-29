<?php
    session_start();
    if(isset($_SESSION['username'])) {
        header("Location: ../private_area/userpage.php");
        exit;
    }
?>
<html>
    <head>
        <title>Recipes - Hello!</title>
        <link rel="stylesheet" href='startingpage.css'>
        <link href="https://fonts.googleapis.com/css2?family=Inspiration&family=Palette+Mosaic&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <nav>
            <div id="logo"> Recipes </div>
        </nav>
        <header>
            <div id='center'>
                <h1>Alla scoperta del mondo!</h1>
                <em>Entra in Recipes!</em>
                <div id='buttons'>
                    <a href="http://localhost/HW1/log/login.php?type=login">Login</a>
                    <a href="http://localhost/HW1/log/login.php?type=signup">Registrati</a>                   
                </div>
            </div>
        </header>
    </body>
</html>