<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="../assets/css/Cambiar_Contrasena_style.css">
</head>
<body>
    <header>
    <?php include("layouts/header.php") ?>
    <p id="Change-P_Header">Change Password</p> 
    </header>

    <?php include("../assets/php/errorMessage.php");
    if(!empty($_SESSION['message'])){
        echo '<script>MostrarError();</script>';
        unset($_SESSION['message']);
    }
    ?>

    <section>
        <div id="Form-group">
            <form action="../controllers/usersController.php" method="POST" autocomplete="off" class="flow">
                <div>
                <input type="password" name="cont-a" placeholder="Ingresar contraseña actual">
                </div>

                <div id="newPass">
                <input type="password"  name="cont-n" placeholder="Ingresar contraseña nueva">
                </div>
                <div>
                <input type="password"  name="verif_cont-n" placeholder="Ingresar constraseña nueva (otra vez)">
                </div>

                <div>
                <button type="submit">Hacer cambios</button>
                </div>
                <input type="hidden" name="_method" value="ChangePassword">
            </form>
        </div>

    </section>
    <footer>
        <p>Hernandez Dean Joshua © 2022</p>
    </footer>
    
</body>
</html>