<?php
    require_once ('login_utils.php');

    session_start();
    if(isset($_SESSION["username"]))
    {
        header("Location: ../private_area/userpage.php");
        exit;
    }
    

    if(!isset($_GET['type'])) {
        header("Location: startingpage.php");
        exit;
    }
    else {
        
        //Sezione Sign-up
        if($_GET['type'] == 'signup') {       
            if(!anyEmpty()) {        
                $signup_errors = array();
                $conn = mysqli_connect("localhost", "root", "", "hw1");

                if(!preg_match('/[a-zA-Z]{2,15}/', $_POST['name'])) {
                    $signup_errors[] = "Nome non valido.";
                }
                if(!preg_match('/[a-zA-Z]{2,15}/', $_POST['surname'])) {
                    $signup_errors[] = "Cognome non valido.";
                }

                if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/",$_POST['email'])) {
                    $errors[] = "Email non valida.";
                }
                if(existsEmail($_POST['email'])) {
                    $signup_errors[] = "Email già utilizzata.";
                }
                
                if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
                    $signup_errors[] = "Username non valido.";
                } else if (existsUsername($_POST['username'])) {
                        $signup_errors[] = "Username già utilizzato.";
                }   

                if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]$/', $_POST["password"])) {
                    $signup_errors[] = "La password richiede caratteri speciali.";
                }
                if (strlen($_POST["password"]) <= 8) {
                    $signup_errors[] = "Caratteri password insufficienti (min. 9)";
                } 


                if(count($signup_errors) == 0) {
                    $email = mysqli_real_escape_string($conn,$_POST['email']);
                    $password = mysqli_real_escape_string($conn,$_POST['password']);

                    $reg_query = "INSERT INTO users(username,name,surname,email,password) VALUES('" .$_POST['username']. "','" .$_POST['name']. "','" .$_POST['surname']. "','".$email. "','".$password."')";
                    $res = mysqli_query($conn, $reg_query);
                    if ($res == FALSE) {
                        $signup_errors[0] = 'La registrazione non è andata a buon fine.';
                    }
                    else {              
                        $_SESSION["username"] = $_POST["username"];
                        header("Location: ../private_area/userpage.php");
                        exit;    
                    }
                    mysqli_close($conn);
                }
            }
        }

        //Sezione Login
        if($_GET['type'] == 'login') {
            if(isset($_POST["username"]) && isset($_POST["password"]))
            {
                $conn = mysqli_connect("localhost", "root", "", "hw1");
                $query = "SELECT * FROM users WHERE username = '".mysqli_real_escape_string($conn,$_POST['username'])."' AND password = '".mysqli_real_escape_string($conn,$_POST['password'])."'";
                $res = mysqli_query($conn, $query);

                if(mysqli_num_rows($res) > 0) {
                    $_SESSION["username"] = $_POST["username"];
                    header("Location: ../private_area/userpage.php");
                    exit;
                }
                else {
                    $login_error = true;
                }
            }
        }

    }
?>

<html>
    <head>
        <title>Recipes - Login</title>
        <link rel="stylesheet" href="startingpage.css">
        <link rel="stylesheet" href="login.css">
        <link href="https://fonts.googleapis.com/css2?family=Inspiration&family=Palette+Mosaic&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@200&display=swap" rel="stylesheet">

        <script src="login.js" defer></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <nav>
            <div id="logo"> Recipes </div>
        </nav>
        <header>

            <!-- Sezione Login -->
            <?php
                if(isset($_GET['type']) && $_GET['type'] == 'login') {
                    echo "<section id='center'>";
                }
                else {
                    echo "<section class='hidden'>";
                }
            ?>

            <h1>Bentornato!</h1>

            <p class='errore'>
            <?php
                if(isset($login_error)) {
                    echo "Credenziali non valide.";
                }
            ?>
            </p>
   
            <form name='login_form' method='post'>
                <label>Username:</label>
                <input type="text" name="username" value="username" class="input_field">
                <label>Password:</label>
                <input type="password" name="password" value="password" class="input_field">
                <div class='access_div'>
                    <input type='submit' value="Accedi" class="access">
                </div>
            </form>
            </section>

            
            <!-- Sezione Sign up -->

            <?php
                if(isset($_GET['type']) && $_GET['type'] == 'signup') {
                    echo "<section id='center'>";
                }
                else {
                    echo "<section class='hidden'>";
                }
            ?>

            <h1>Sarai presto dei nostri!</h1>

            <p class='errore'>
            <?php
                if(isset($signup_errors))
                {
                    foreach ($signup_errors as $el) {
                        echo $el."<br>";
                    }
                }
            ?> 
            </p>

            
            <form name='signup_form' method='post' class='signup'>
                <div class='div_name'>
                    <label>Nome:</label>
                    <input type="text" name="name" value="" class="input_field">
                </div>
                <div class='div_surname'>
                    <label>Cognome:</label>
                    <input type="text" name="surname" value="" class="input_field">
                </div>
                <div class='div_email'>                    
                    <label>Email:</label>
                    <input type="text" name="email" value="es. example1@domain.com" class="input_field">
                </div>
                <div class='div_username'>                   
                    <label>Username:</label>                                        
                    <input type="text" name="username" value="es. user123_" class="input_field">
                </div>
                <div class='div_password'>
                    <label>Password:</label>
                    <input type="password" name="password" value="" class="input_field">
                </div>
                <div class='access_div'>
                    <input type='submit' value="Registrati" class="access">
                </div>
            </form>
            </section>

        </header>
        
    </body>
</html>