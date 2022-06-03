<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Red-it</title>
    <link rel="stylesheet" href="../assets/css/index_style.css">
</head>
<body>
    <header>
    <?php include("layouts/header.php")?>
    </header>

    <section>
        
        <div id="Create-Post">
            <div>
            <img src="../resources/images/red-it_logo.png" alt="" id="red-it_logo"></a>
            <img src="../resources/images/megaphone.png" alt="" id="megaphone"></a>
            </div>
            <div>
            <a target="_self" href="Create_Thread.php">
            <button type="Start-post">Crear Post</button>
            </a>
            </div>
        </div>

        <!--
        <div id="Filter">
            <h3>Filtrar post / Tipo de post</h3>
            <div id="Filter-tab">
                <button class="f-tab">Popular</button>
                <button class="f-tab">Reciente</button>
            </div>
        </div> -->

        <!--<div class="Comment">
            <div class="cmt-img">
            <img src="../resources/images/red-it_logo.png" alt=""></a>
            </div>
            <div class="Rating-box">
                <p class="up-arrow">&#9650;</p>
                <p class="rating-number">1.4k</p>
                <p class="down-arrow">&#9660;</p>
            </div>
            <div>
                <div class="user-date_box">
                <p class="username">Usuario123</p>
                <p class="uploadtime">Hace 12 horas</p>
                </div>
                <div class="text-box">
                <p class="Post-text">¿Por que cuando hiervo una papa se ablanda, pero cuando hiervo un huevo se endurece?</p>
                </div>
            </div>
        </div> 
        -->

        <div id="post-list">

        <!--
        <div class="Post" type="image">
            <div class="Rating-box">
                <p class="up-arrow">&#9650;</p>
                <p class="rating-number">2k</p>
                <p class="down-arrow">&#9660;</p>
            </div>
            <div>
                <div class="user-date_box">
                    <p class="username">Usuario987</p>
                    <p class="uploadtime">Hace 21 horas</p>
                </div>
                <div class="title-box">
                    <p class="Post-title">Miren mi perro, ¿apoco no es muy bello?</p>
                </div>
                <div class="Post-Image">   
                    <img src="https://picsum.photos/500"  alt="img">
                </div>
                <div class="Comment-box">
                <p class="Num_comments">120 Comentarios</p>
                <p class="Post_viewlink">Visitar Hilo</p>
                </div>
            </div>
        </div>
        -->

        </div>

        
        <?php 
        include("modal_post.php");
        include("../assets/php/app.php");
        ?>

<!--
        <div class="Post" type="text">
            <div class="Rating-box">
                <p class="up-arrow">&#9650;</p>
                <p class="rating-number">1.4k</p>
                <p class="down-arrow">&#9660;</p>
            </div>
            <div>
                <div class="user-date_box">
                <p class="username">Usuario123</p>
                <p class="uploadtime">Hace 12 horas</p>
                </div>
                <div class="title-box">
                <p class="Post-title">¿Por que cuando hiervo una papa se ablanda, pero cuando hiervo un huevo se endurece?</p>
                </div>
                <div class="Comment-box">
                <p class="Num_comments">15 Comentarios</p>
                <p class="Post_viewlink">Visitar Hilo</p>
                </div>
            </div>
        </div>

        <div class="Post" type="image">
            <div class="Rating-box">
                <p class="up-arrow">&#9650;</p>
                <p class="rating-number">2k</p>
                <p class="down-arrow">&#9660;</p>
            </div>
            <div>
                <div class="user-date_box">
                    <p class="username">Usuario987</p>
                    <p class="uploadtime">Hace 21 horas</p>
                </div>
                <div class="title-box">
                    <p class="Post-title">Miren mi perro, ¿apoco no es muy bello?</p>
                </div>
                <div class="Post-Image">   
                    <img src="https://picsum.photos/500"  alt="img">
                </div>
                <div class="Comment-box">
                <p class="Num_comments">120 Comentarios</p>
                <p class="Post_viewlink">Visitar Hilo</p>
                </div>
            </div>
        </div>

        <div class="Post" type="video">
            <div class="Rating-box">
                <p class="up-arrow">&#9650;</p>
                <p class="rating-number">-3k</p>
                <p class="down-arrow">&#9660;</p>
            </div>
            <div>
                <div class="user-date_box">
                    <p class="username">Usuario1</p>
                    <p class="uploadtime">Hace 3 horas</p>
                </div>
                <div class="title-box">
                    <p class="Post-title">El reggaeton es Arte</p>
                </div>
                <div class="Post-Video">
                    <video width="100%" controls> </video>
                </div>
                <div class="Comment-box">
                <p class="Num_comments">67 Comentarios</p>
                <p class="Post_viewlink">Visitar Hilo</p>
                </div>
            </div>
        </div>
-->
    </section>
    <footer>
        <p>Hernandez Dean Joshua © 2022</p>
    </footer>
</body>
</html>