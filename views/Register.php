<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/Register_style.css">
</head>
<body>
    <header>
        <img src="../resources/images/red-it_logo.png" alt="" id="red-it_logo"></a>
        <a target="_self" href="index.php">
            <p id="Red-it" style="color: black;">Red-it</p>
        </a>
        <p id="Register_Header">Register</p>
    </header>

    <?php
    include("../assets/php/errorMessage.php");
    if(isset($_SESSION)){
        if(isset($_SESSION['message'])){
            echo '<script>MostrarError();</script>';
        }
    session_destroy();
    }else
    {
        session_start();
    }
    ?>

    <section>
        <div id="Form-group">
            <form action="../controllers/usersController.php" method="POST" autocomplete="off" class="flow" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="CreateUser">
                <div>
                <input type="text" id="usuario" name="username" placeholder="Nombre de Usuario">
                </div>
                <div>
                <input type="password" id="ing_contraseña" name="password" placeholder="Ingresar contraseña">
                </div>
                <div>
                <input type="password" id="verif_contraseña" name="verif_contraseña" placeholder="Ingresar constraseña nuevamente">
                </div>
                <div>
                <button type="submit">Registrar</button>
                </div>
            </form>
        </div>

        <p>¿Ya eres usuario?</p>
        <br>
        <div id="link"><a href="login.php" style="text-align:center">INICIA SESIÓN</a></div>
        <br>

    </section>
    <footer>
        <p>Hernandez Dean Joshua © 2022</p>
    </footer>
</body>
</html>