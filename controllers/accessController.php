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
    if ($_POST["_method"] === "login") {

        session_start();

        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        try {
            $query = $connection->prepare('SELECT * FROM users WHERE username = :username');
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->execute();

            if ($query->rowCount() === 0) {
                $_SESSION['message'] = "Usuario no encontrado";
                header('Location: http://localhost/red-it/views/login.php');
                exit();
            }

            $user;

            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $user = new User($row["id_user"], $row["username"], $row["password"], $row["rating"], $row["type"]);
            }

            if (!password_verify($password, $user->getPassword())) {
                $_SESSION['message'] = "Contraseña invalida";
                header('Location: http://localhost/red-it/views/login.php');
                exit();
            }

            $_SESSION["id_user"] = $user->getId();
            $_SESSION["username"] = $user->getUsername();
            $_SESSION["rating"] = $user->getRating();
            $_SESSION["type"] = $user->getType();

            header('Location: http://localhost/red-it/views/');
            exit();
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
}

?>