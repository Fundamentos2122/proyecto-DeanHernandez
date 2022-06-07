<?php 

include("../models/DB.php");
include("../models/User.php");


try {
    $connection = DBConnection::getConnection();
}
catch(PDOException $e) {
    error_log("Error de conexión - " . $e, 0);

    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    //Pantalla Configuracion de nombre
    if ($_POST["_method"] === "ChangeUsername"){

        session_start();
        
        if (array_key_exists("user-n", $_POST) && array_key_exists("id_user", $_SESSION)){

            if($_POST["user-n"] === ""){
                $_SESSION['message'] = "No introduciste un nuevo nombre";
                header('Location: http://localhost/red-it/views/Cambiar_Usuario.php');
                exit();
            }

        try{
            putUsername($_SESSION["id_user"], $_POST["user-n"]);
         
            $_SESSION["username"] = $_POST["user-n"];
            header('Location: http://localhost/red-it/views/index.php');
            exit();
        }
        catch(PDOException $e) {
            $_SESSION['message'] = "Ya existe un usuario con ese nombre";
            header('Location: http://localhost/red-it/views/Cambiar_Usuario.php');
            exit();
        }
        }
        else{
            $_SESSION['message'] = "Error al encotrar variables";
            header('Location: http://localhost/red-it/views/Cambiar_Usuario.php');
            exit();
        } 

    }
    //Pantalla configuracion de contraseña
    else if($_POST["_method"] === "ChangePassword"){
        
        session_start();

        //Verificar contraseña original
        try{

            $id_user = $_SESSION["id_user"];
            $password = $_POST["cont-a"];

            $query2 = $connection->prepare('SELECT * FROM users WHERE id_user = :id_user');
            $query2->bindParam(':id_user', $id_user, PDO::PARAM_STR);
            $query2->execute();

            if ($query2->rowCount() === 0) {
                $_SESSION['message'] = "Usuario no encontrado";
                header('Location: http://localhost/red-it/views/Cambiar_Contrasena.php');
                exit();
            }

            $user;

            while($row = $query2->fetch(PDO::FETCH_ASSOC)) {
                $user = new User($row["id_user"], $row["username"], $row["password"], $row["rating"], $row["type"]);
            }

            if (!password_verify($password, $user->getPassword())) {
                $_SESSION['message'] = "Contraseña invalida";
                header('Location: http://localhost/red-it/views/Cambiar_Contrasena.php');
                exit();
            }

        }catch(PDOException $e){
            echo $e;
            exit();
        }

        if($_POST["cont-a"] === ""){
            $_SESSION['message'] = "No introduciste una contraseña";
            header('Location: http://localhost/red-it/views/Cambiar_Contrasena.php');
            exit();
        }

        if($_POST["cont-n"] === ""){
            $_SESSION['message'] = "No introduciste una contraseña";
            header('Location: http://localhost/red-it/views/Cambiar_Contrasena.php');
            exit();
        }

        if(trim($_POST["cont-n"]) !== trim($_POST["verif_cont-n"])){
            $_SESSION['message'] = "Las contraseñas nuevas no coinciden";
            header('Location: http://localhost/red-it/views/Cambiar_Contrasena.php');
            exit();
        }
        
        if (array_key_exists("cont-n", $_POST) && array_key_exists("id_user", $_SESSION)){
        try{
            putPassword(trim($_SESSION["id_user"]), trim($_POST["cont-n"]));

            header('Location: http://localhost/red-it/views/index.php');
            exit();
        }
        catch(PDOException $e) {
            echo $e;
            exit();
         }
        }
        else{
            $_SESSION['message'] = "Error al encontrar variables";
            header('Location: http://localhost/red-it/views/Cambiar_Contrasena.php');
            exit();
        } 

    }
    //Pantalla Configuracion - Boton de elminar usuario
    else if($_POST["_method"] === "DeleteUser"){
        session_start();

        if(array_key_exists("id_user",$_SESSION)){
            try{
                deleteUser($_SESSION["id_user"]);
                session_destroy();
                header('Location: http://localhost/red-it/');
                exit();
            }
            catch(PDOException $e){
                echo $e;
                exit();
            }
        }

    }
    //Pantalla de Registro de usuario
    else if($_POST["_method"] === "CreateUser"){

        session_start();

        if($_POST["password"] === ""){
            $_SESSION['message'] = "No introduciste una contraseña";
            header('Location: http://localhost/red-it/views/Register.php');
            exit();
        }

        if($_POST["username"] === ""){
            $_SESSION['message'] = "No introduciste un nombre de usuario";
            header('Location: http://localhost/red-it/views/Register.php');
            exit();
        }

        if(trim($_POST["password"]) !== trim($_POST["verif_contraseña"])){
            $_SESSION['message'] = "No coinciden las contraseñas";
            header('Location: http://localhost/red-it/views/Register.php');
            exit();
        }
    
        
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        
        $password = password_hash($password, PASSWORD_DEFAULT);
    
        $type = "normal";
        $rating = 0;

        try {

            $q = $connection->prepare('SELECT * FROM users WHERE username = :username');
            $q->bindParam(':username', $username, PDO::PARAM_STR);
            $q->execute();
            if($q->rowCount() === 0){
    
                try {
                    $query = $connection->prepare('INSERT INTO users(username, password, rating, type) values(:username, :password, :rating, :type)');
                    $query->bindParam(':username', $username, PDO::PARAM_STR);
                    $query->bindParam(':password', $password, PDO::PARAM_STR);
                    $query->bindParam(':rating', $rating, PDO::PARAM_INT);
                    $query->bindParam(':type', $type, PDO::PARAM_STR);
                    $query->execute();
        
                    if($query->rowCount() === 0) {
                        $_SESSION['message'] = "Error en la inserción";
                        header('Location: http://localhost/red-it/views/Register.php');
                        exit();
                    }
                    else {
                        
                        header('Location: http://localhost/red-it/views/login.php');
                        exit();
                    }
                }
                catch(PDOException $e) {
                        $_SESSION['message'] = "Error en la inserción";
                        header('Location: http://localhost/red-it/views/Register.php');
                        exit();
                }
            }
            else{ 
                $_SESSION['message'] = "Ya existe un usuario con ese nombre";
                header('Location: http://localhost/red-it/views/Register.php');
                exit();
            }
        }
        catch(PDOException $e) {
            $_SESSION['message'] = "Error en la recuperación de usuarios";
            header('Location: http://localhost/red-it/views/Register.php');
            exit();
        }

    }
}

function putUsername($id_user, $username) {
    global $connection;

    try {

        $q = $connection->prepare('SELECT * FROM users WHERE username = :username');
        $q->bindParam(':username', $username, PDO::PARAM_STR);
        $q->execute();
        if($q->rowCount() === 0){

            $query = $connection->prepare('UPDATE users SET username = :username WHERE id_user = :id_user');
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
            $query->execute();

            if($query->rowCount() === 0) {
                $_SESSION['message'] = "Error en la actualización";
                header('Location: http://localhost/red-it/views/Cambiar_Usuario.php');
                exit();
            }
            else{

                //Despues de modificar el nombre de usuario se actualizan los posts y comentarios con el nuevo nombre

                $query = $connection->prepare('UPDATE posts SET username = :username WHERE id_user = :id_user');
                $query->bindParam(':username', $username, PDO::PARAM_STR);
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->execute();

                $query = $connection->prepare('UPDATE comments SET username = :username WHERE id_user = :id_user');
                $query->bindParam(':username', $username, PDO::PARAM_STR);
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->execute();
                //echo "Registro guardado";
            }
        }
        else{ 
            $_SESSION['message'] = "Ya existe un usuario con ese nombre";
            header('Location: http://localhost/red-it/views/Cambiar_Usuario.php');
            exit();
        }
    }
    catch(PDOException $e) {
        echo $e;
        exit();
    }
}

function putPassword($id_user, $password) {
    global $connection;

    try {

        $password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = $connection->prepare('UPDATE users SET password = :password WHERE id_user = :id_user');
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $query->execute();

        if($query->rowCount() === 0) {
            $_SESSION['message'] = "Error en la actualización";
            header('Location: http://localhost/red-it/views/Cambiar_contrasena.php');
            exit();
        }
        else {
                //echo "Registro guardado";
        }
    }
    catch(PDOException $e) {
        echo $e;
    }
}

function deleteUser($id_user) {
    global $connection;

    try {    
    $query_string = 'DELETE FROM users WHERE id_user = :id_user';

    if($query = $connection->prepare($query_string)){
        $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $query->execute();
    }
    else
        $_SESSION['message'] = "No introduciste una contraseña";
        header('Location: http://localhost/red-it/views/Register.php');
        exit();
    }
    catch(PDOException $e) {
        echo $e;
        exit();
    }
}

?>