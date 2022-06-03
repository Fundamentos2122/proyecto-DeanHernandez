<?php 
    //Indicamos que haremos uso de la sesión
    session_start();

    if(!array_key_exists("username", $_SESSION)) {
        header('Location: http://localhost/red-it/');
        exit();
    }

?>

<img src="../resources/images/red-it_logo.png" alt="" id="red-it_logo"></a>
    <a target="_self" href="index.php">
    <p id="Red-it" style="color: black;">Red-it</p>
    </a>

        <div id="User-details">
            <p id="Welcome">¡Bienvenido <?php echo $_SESSION["username"] ?>!</p>
            <div id="links">
                <a href="Configuration.php">Configurar cuenta</a>
                <a href="login.php">Cerrar sesión</a>
            </div>
            <p id="rating">Rating: <?php echo $_SESSION["rating"] ?></p>
        </div>