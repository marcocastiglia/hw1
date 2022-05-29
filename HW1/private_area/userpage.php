<?php
    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("Location: ../log/startingpage.php");
        exit;
    }
?>

<html>
    <head>
        <title>YourPage - Recipes</title>
        <link rel="stylesheet" href="../log/startingpage.css">
        <link rel="stylesheet" href="userpage.css">

        <link href="https://fonts.googleapis.com/css2?family=Inspiration&family=Palette+Mosaic&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src='userpage.js' defer></script>
    </head>
    <body>
        <div id="base">

            <nav>
                <div id="logo"> Recipes </div>
            </nav>
            <main>

                <div class='profilo'>
                    <div>
                        <div class='links'>
                            <a href='homepage.php' class="home">Home</a>
                            <a href='../log/logout.php' class='logout'>Logout</a>
                        </div>
                    </div>
                    <img src='./images/profile_default.jpg'>
                    <span>
                        <?php
                            if(isset($_SESSION['username']))
                                echo $_SESSION['username'];
                        ?>
                    </span>
                </div>

                <section id="options">
                    <a class="profilo">
                        <img src="./images/profile_default.jpg">
                        <h4 class='hidden'>Profilo</h4>
                    </a>
                    <a href='homepage.php?fav=true' class="preferiti">
                        <img src="./images/not_favorite.png">
                        <h4 class='hidden'>Preferiti</h4>
                    </a>
                    <a class="scrivi">
                        <img src="./images/writing.png">
                        <h4 class='hidden'>Scrivi</h4>
                    </a>
                    <a class="modifica">
                        <img src="./images/pen_icon.png">
                        <h4 class='hidden'>Modifica</h4>
                    </a>
                    <a class="pro_gif">
                        <img src="./images/giphy_logo.png">
                        <h4 class='hidden'>GIF profilo</h4>
                    </a>
                </section>
                <section id="mainspace">

                    <article class='profilo show_flex'>
                        <h4>Ecco le ricette che hai pubblicato.</h4>
                        <section class='post_section'>
                            <!-- Struttura POST

                            <div class='post_div' data-post_id=''>
                                <span class='rec_title'></span>
                                <div class='ingr_list'>
                                    <div></div><div></div>
                                </div>
                                <p class='descr'></p>
                                <img src=''>
                                <div class='nlike_ncomment'>
                                    <div class='nlikes'></div>
                                    <div class='ncomments'></div>
                                </div>
                                <button class='delete_post'></button>

                            </div> -->
                                       
                        </section>
                        <section class='modal_view hidden'>
                            <div class='container'>
                                <h4 class='error'>Sei sicuro di voler eliminare questo post?</h4>
                                <div></div>
                                <div class='buttons'>
                                    <button class='confirm'>Conferma</button>
                                    <button class='cancel'>Annulla</button>
                                </div>
                            </div>
                        </section>
                    </article>

                    


                    <article class='scrivi hidden'>
                        <p class='alarms hidden'></p>
                        <form name='scrivi_form' method='post'>
                            <div class='title'>
                                <label>Title:</label>
                                <input type="text" name="title">
                            </div>                
                            <div class='ingredients'>
                                <label>Ingredients:</label>
                                <div class='add_ingr'>
                                    <input type="text" name="ingredient[]"> 
                                    <img src='./images/add_icon.png'>
                                </div> 
                                <div class='more_ingr'></div>             
                            </div>
                            <div class='text_descr'>
                                <label>Text:</label>
                                <textarea name="textarea"></textarea>
                            </div>
                            <div class='search_image_to_insert'>
                                <label>Cerca un'immagine inserendo una parola-chiave:</label>
                                <div class='search'>
                                    <input type='text' name='image_keyword'>
                                    <button>Cerca</button>
                                </div>
                                <div id='image_results'>                   
                                </div>
                            </div>
                            <div class='submit'>
                                <input type='submit' value='Pubblica'>
                            </div>
                            <div class='reset'>
                                <input type='reset' value='Ripristina'>
                            </div>
                        </form>
                    </article>

                    <article class='modifica hidden'>
                        <h4 class='error'>Stai apportando delle modifiche al tuo profilo.</h4>
                        <div class='confirm_pw'>
                            <span> 
                                <?php
                                    if(isset($_SESSION['username']))
                                    echo "<em>".$_SESSION['username']."</em>";
                                ?>
                                conferma la password per procedere:</span>
                            <form name='confirm_pw' method='post'>
                                <input type='password' name='password'>
                                <input type='submit' name='submit' value='Invia'>
                            </form>
                            <p class='error hidden'></p>
                            <a href='modify_account.php' class='hidden'>Modifica</a>
                        </div>
                    </article>


                    <article class='pro_gif hidden'>
                        <h4>Cerca una GIF da inserire come GIF profilo:</h4>
                        <div class='container_gifs'>
                            <form name='form_giphy' method='post' class='up_form'>
                                <input type='text' name='keyword' class='text'>
                                <input type='submit' value='Cerca'>
                            </form>
                            <div id='gif_results'></div>
                            <form name='upload_gif' method='post 'class='down_form hidden'>
                                <input type='submit' value='Carica'>
                            </form>
                        </div>
                    </article>
                

                    
                </section>
                
            </main>
            <footer>
                Unict - Marco Castiglia - 1000003997
            </footer>

        </div>
    </body>
</html>