<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Username</title>
    <link rel="stylesheet" href="../assets/css/Cambiar_Usuario_style.css">
</head>
<body>
    <header>
    <?php include("layouts/header.php")?>
    <p id="Change-U_Header">Change Username</p>
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

                <p id="Username">Actual nombre: <?php echo $_SESSION["username"] ?></p>
                <input type="hidden" name="_method" value="ChangeUsername">
                <div>
                <input type="text" id="user-n" name="user-n" placeholder="Ingresar nuevo nombre de usuario">
                </div>
                
                <div>
                <button type="submit">Hacer cambios</button>
                </div>
            </form>
        </div>

    </section>

    <footer>

        <p>Hernandez Dean Joshua © 2022</p>

    </footer>
    
</body>
</html>