<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration</title>
    <link rel="stylesheet" href="../assets/css/Configuration_style.css">
</head>
<body>
    <header>
    <?php include("layouts/header.php")?>
    <p id="Conf_Header">Configuration</p>
    </header>
    <section>
        
        <div id="Form-group">
                <div>
                    <a target="_self" href="Cambiar_Contrasena.php">
                    <button type="Cambiar" id="cc">Cambiar Contraseña</button>
                    </a>
                </div>
                <div>
                    <a target="_self" href="Cambiar_Usuario.php">
                    <button type="Cambiar" id="cn">Cambiar Nombre de usuario</button>
                    </a>
                </div>
                <div>
                    <form action="../controllers/usersController.php" method="POST" autocomplete="off" class="flow">
                    <input type="hidden" name="_method" value="DeleteUser">
                    <button type="Baja" onclick="">Dar cuenta de Baja</button>
                    </form>
                </div>
        </div>

    </section>
    <footer>
        <p>Hernandez Dean Joshua © 2022</p>
    </footer>
    
</body>
</html>