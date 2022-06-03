<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/login_style.css">
</head>
<body>

<?php 
session_start();
session_destroy();
?>

    <header>
        <img src="../resources/images/red-it_logo.png" alt="" id="red-it_logo"></a>
        <a target="_self" href="index.php">
            <p id="Red-it" style="color: black;">Red-it</p>
        </a>
        <p id="Login_Header">Login</p>
    </header>
    <section>
        <div id="Form-group">
            <form action="../controllers/accessController.php" method="POST" autocomplete="off" class="flow">
                <input type="hidden" name="_method" value="POST">
                <div>
                <input type="text" id="usuario" name="username" placeholder="Usuario">
                </div>
                <div>
                <input type="password" id="contraseña" name="password" placeholder="Contraseña">
                </div>
                <div>
                <button type="submit">Iniciar</button>
                </div>
            </form>
        </div>

        <p>¿Nuevo a Red-it?</p>
        <br>
        <div id="link"><a href="Register.php" style="text-align:center">REGISTRATE</a></div>
        <br>

    </section>
    <footer>
        <p>Hernandez Dean Joshua © 2022</p>
    </footer>
</body>
</html>