<?php
    require_once ('../log/login_utils.php');

    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("Location: ../log/startingpage.php");
        exit;
    }
    if($_GET['valid'] !== 'true') {
        header("Location: userpage.php");
        exit;
    }

    $conn = mysqli_connect("localhost", "root", "", "hw1");
    $query = "SELECT * from users where username ='".$_SESSION['username']."'";
    $info = mysqli_fetch_assoc(mysqli_query($conn, $query));

    
    if(!anyEmpty()) {        
        $errors = array();
        
        if(!preg_match('/[a-zA-Z]{2,15}/', $_POST['name'])) {
            $errors[] = "Nome non valido.";
        }
        if(!preg_match('/[a-zA-Z]{2,15}/', $_POST['surname'])) {
            $errors[] = "Cognome non valido.";
        }

        if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/",$_POST['email'])) {
            $errors[] = "Email non valida.";
        }
        if(strcmp($_POST['email'],$info['email']) && existsEmail($_POST['email'])) {
            $errors[] = "Email già utilizzata.";
        }
        
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
            $errors[] = "Username non valido.";
        } else if (strcmp($_POST['username'],$_SESSION['username']) && existsUsername($_POST['username'])) {
                $errors[] = "Username già utilizzato.";
        }   

        $uppercase = preg_match('@[A-Z]@', $_POST["password"]);
        $lowercase = preg_match('@[a-z]@', $_POST["password"]);
        $number    = preg_match('@[0-9]@', $_POST["password"]);
        $specialChars = preg_match('@[^\w]@', $_POST["password"]);
        if(!$uppercase || !$lowercase || !$number || !$specialChars) {
            $errors[] = "La password richiede un numero, una lettera maiuscola, una minuscola e un carattere speciale.";
        }
        if (strlen($_POST["password"]) < 8) {
            $errors[] = "Caratteri password insufficienti (min. 8)";
        } 


        if(count($errors) == 0) {
            $email = mysqli_real_escape_string($conn,$_POST['email']);
            $password = mysqli_real_escape_string($conn,$_POST['password']);

            $query = "UPDATE users SET username ='".$_POST['username']."', name = '" .$_POST['name']."', surname = '".$_POST['surname']."', email = '".$email."', password = '".$password."' 
                        WHERE username = '".$_SESSION['username']."'";
            $res = mysqli_query($conn, $query);
            if ($res == FALSE) {
                $errors[0] = 'La modifica non è andata a buon fine.';
            }
            else {
                $errors[0] = 'La modifica è avvenuta correttamente.';
                header("Location: ../private_area/userpage.php");
                exit;    
            }
            mysqli_close($conn);
        }
}    
?>

<html>
    <head>
        <title>Recipes - Modify</title>
        <link rel="stylesheet" href="../log/startingpage.css">
        <link rel="stylesheet" href="../log/login.css">
        <link href="https://fonts.googleapis.com/css2?family=Inspiration&family=Palette+Mosaic&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@200&display=swap" rel="stylesheet">

        <script src="modify_account.js" defer></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <nav>
            <div id="logo"> Recipes </div>
        </nav>
        <header> 
            <a href='userpage.php' id='go_back'><img src='./images/left_arrow.png'></a>      
            <section id='center'>

            <h1>Modifica il tuo account!</h1>

            <p class='errore'>
            <?php
                if(isset($errors))
                {
                    foreach ($errors as $el) {
                        echo $el."<br>";
                    }
                }
            ?> 
            </p>          
            
            <form name='signup_form' method='post' class='signup' id='mod_form'>
                <div class='div_name'>
                    <label>Nome:</label>
                    <input type="text" name="name" value='<?php echo $info['name'];?>' class="input_field">
                </div>
                <div class='div_surname'>
                    <label>Cognome:</label>
                    <input type="text" name="surname" value="<?php echo $info['surname'];?>" class="input_field">
                </div>
                <div class='div_email'>                    
                    <label>Email:</label>
                    <input type="text" name="email" value="<?php echo $info['email'];?>" class="input_field">
                </div>
                <div class='div_username'>                   
                    <label>Username:</label>                                        
                    <input type="text" name="username" value="<?php echo $info['username'];?>" class="input_field">
                </div>
                <div class='div_password'>
                    <label>Password:</label>
                    <input type="text" name="password" value="<?php echo $info['password'];?>" class="input_field">
                </div>
                <div class='access_div'>
                    <input type='submit' value="Conferma modifiche" class="access">
                </div>
            </form>
            </section>

        </header>
        
    </body>
</html>