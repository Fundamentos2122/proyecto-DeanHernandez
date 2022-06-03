<?php 

include("../models/DB.php");


try {
    $connection = DBConnection::getConnection();
}
catch(PDOException $e) {
    error_log("Error de conexión - " . $e, 0);

    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    

    if ($_POST["_method"] === "ChangeUsername"){

        session_start();
        
        if (array_key_exists("user-n", $_POST) && array_key_exists("id_user", $_SESSION)){
        try{
            putUsername($_SESSION["id_user"], $_POST["user-n"]);
         
            $_SESSION["username"] = $_POST["user-n"];

            header('Location: http://localhost/red-it/views/index.php');
        }
        catch(PDOException $e) {
            echo $e;
         }
        }
        else{
           echo "Error al encontrar variables";
        } 

    }
    else if($_POST["_method"] === "ChangePassword"){
        
        session_start();

        if(trim($_POST["cont-n"]) !== trim($_POST["verif_cont-n"])){
            echo "Las contraseñas nuevas no coinciden"; //Pendiente modificar la manera de alertar que no coinciden
        }
        
        if (array_key_exists("cont-n", $_POST) && array_key_exists("id_user", $_SESSION)){
        try{
            putPassword(trim($_SESSION["id_user"]), trim($_POST["cont-n"]));

            header('Location: http://localhost/red-it/views/index.php');
        }
        catch(PDOException $e) {
            echo $e;
         }
        }
        else{
           echo "Error al encontrar variables";
        } 

    }else if($_POST["_method"] === "DeleteUser")
        {
            session_start();

            if(array_key_exists("id_user",$_SESSION))
            try{
            deleteUser($_SESSION["id_user"]);
            session_destroy();
            header('Location: http://localhost/red-it/');
            }
            catch(PDOException $e){
                echo $e;
            }

        }
    else{

    if(trim($_POST["password"]) !== trim($_POST["verif_contraseña"])){
        echo "Las contraseñas no coinciden"; //Pendiente modificar la manera de alertar que no coinciden
    }
    
    else{
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
        
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $type = "normal";
    $rating = 0;
    
    try {
       $query = $connection->prepare('INSERT INTO users(username, password, rating, type) values(:username, :password, :rating, :type)');
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->bindParam(':rating', $rating, PDO::PARAM_INT);
        $query->bindParam(':type', $type, PDO::PARAM_STR);
        $query->execute();

        if($query->rowCount() === 0) {
            echo "Error en la inserción";
        }
        else {
            header('Location: http://localhost/red-it/views/login.php');
        }
    }
    catch(PDOException $e) {
        echo $e;
     }
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
                echo "Error en la actualización";
                exit();
            }
            else{
                //echo "Registro guardado";
            }
        }
        else{ echo "Ya existe un usuario con ese nombre";
        exit();}
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
            echo "Error en la actualización";
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
        echo "Error deleting record";
    }
    catch(PDOException $e) {
        echo $e;
        exit();
    }
}

?>