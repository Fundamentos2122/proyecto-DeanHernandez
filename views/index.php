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

    <?php include("../assets/php/errorMessage.php");
    if(!empty($_SESSION['message'])){
        echo '<script>MostrarError();</script>';
        unset($_SESSION['message']);
    }
    ?>

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

        <div id="post-list"></div>

        <?php 
        include("modal_post.php");
        include("../assets/php/app.php");
        ?>

    </section>
    <footer>
        <p>Hernandez Dean Joshua © 2022</p>
    </footer>
</body>
</html>