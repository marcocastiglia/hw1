<?php
    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("Location: ../log/startingpage.php");
        exit;
    }

    if(isset($_GET['fav'])) {
        if($_GET['fav'] === 'true') {
            $fav_flag = 1;
        } else {
            $fav_flag = 0;
        }
    }
?>

<html>
    <head>
        <title>HomePage - Recipes</title>
        <link rel="stylesheet" href="../log/startingpage.css">
        <link rel="stylesheet" href="homepage.css">

        <link href="https://fonts.googleapis.com/css2?family=Inspiration&family=Palette+Mosaic&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src='homepage.js' defer></script>
    </head>
    <body>
        <form name='hidden_info' id='hidden_info'>
            <input type='hidden' name='fav_info' value='<?php echo $fav_flag;?>' >
        </form>

        <div id="base">

            <nav>
                <div id="logo"> Recipes </div>
            </nav>  
            <div class='nav_2'>
                <div class='search_by_ingredient'>
                    <form name='search_by_ingredient' method='post'>
                        <label>Cerca un ingrediente:</label>
                        <input type='text' name='ingredient' class='inputstyle'>
                        <input type='submit' name='submit' value='Cerca' class='inputstyle submit'>
                    </form>
                </div>
                <div class='links'>
                    <a href='userpage.php' class="userpage">Profile</a>
                    <a href='../log/logout.php' class='logout'>Logout</a>
                </div>
            </div>
            <main>
                <section class='info'>
                    <div class='profile_info'>
                        <div class='div_username'>
                            <?php echo '@'.$_SESSION['username']; ?>
                        </div>
                        <div class='profile_img'>
                            <img src='./images/profile_default.jpg'>
                        </div>
                        <div id='statistics'>
                            <div class='like'>
                                <h4>Like:</h4>
                                <h4 class='number'></h4>
                            </div>
                            <div class='fav'>
                                <h4>Preferiti:</h4>
                                <h4 class='number'></h4>
                            </div>
                            <div class='comment'>
                                <h4>Commenti:</h4>
                                <h4 class='number'></h4>
                            </div>
                        </div>
                    </div>
                    <img src='./images/up_arrow.png' id='go_up'>
                    
                </section>

                <section class='post_section'>

                    <!-- Struttura

                    <h2 class='error'></h2>
                    <a href='homepage.php' id='backHome'></a>
                     -->

                    <!-- Struttura POST 

                    <div class='post_div' data-post_id=''>
                        <div class='div_username'></div>
                        <span class='rec_title'></span>
                        <div class='ingr_list'>
                            <div>/div><div></div>
                        </div>
                        <p class='descr'></p>
                        <img src=''>
                        <div class='nlike_ncomment'>
                            <div class='nlikes'>
                                <img src='./images/dislike.png' class='like_dislike' data-like_post='false'>
                                <span></span>
                            </div>
                            <div class='favorite'>
                                <img src='./images/not_favorite.png' class='fav_notfav' data-fav_post='false'>
                            </div>
                            <div class='ncomments'>
                                <img src='./images/disable_comment.png' class='enable_read_comments' data-enable_comm='false'>
                                <span></span>
                            </div>
                        </div>

                    </div> -->
                </section>

                <section class='comment'>
                    <div class='div_comments comments_disabled'>
                        <div id='published_comments' data-post_id='null'>
                            <!-- Struttura commento

                            <div class='single_comment' data-comm_id=''>
                                <div class='head'>
                                    <div class='div_username'></div>
                                    <img src='./images/delete_comment.png' class='delete'>
                                </div> 
                                <p class='descr'></p>
                            </div> -->                            
                        </div>
                        <div class='write_comment'> 
                            <form name='publish_comment' method='post'>
                                <div class='div_username'>
                                    <?php echo '@'.$_SESSION['username']; ?>
                                </div>
                                <label>Commenta:</label>
                                <textarea name="textarea" disabled></textarea>
                                <input type='submit' name='submit' value='Pubblica' disabled>
                            </form>
                        </div>
                    </div>
                </section>

                
            </main>
            <footer>
                Unict - Marco Castiglia - 1000003997
            </footer>

        </div>
    </body>
</html>

