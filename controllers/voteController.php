<?php 

include("../models/DB.php");
include("../models/Post_Vote.php");
include("../models/Comment_Vote.php");
include("../models/Post.php");
include("../models/Comment.php");
include("../models/User.php");


try {
    $connection = DBConnection::getConnection();
}
catch(PDOException $e) {
    error_log("Error de conexión - " . $e, 0);

    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){

    if ($_POST["_method"] === "Vote_Post"){

        session_start();

        if(array_key_exists("id_post", $_POST) && array_key_exists("value", $_POST) && array_key_exists("id_user", $_SESSION) ){

            $id_user = $_SESSION["id_user"];
            $id_post = $_POST["id_post"];
            $value = $_POST["value"];

            try{
                $query = $connection->prepare('INSERT INTO post_votes VALUES(:id_post, :id_user, :value)');
                $query->bindParam(':id_post', $id_post, PDO::PARAM_INT);
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->bindParam(':value', $value, PDO::PARAM_INT);
           
                $query->execute();
         
                if($query->rowCount() === 0) {
                    $_SESSION['message'] = "Error en la inserción";
                    header('Location: http://localhost/red-it/views/index.php');
                    exit();
                }
                else {
                    //Insercion exitoso

                    /*Actualizar rating de usuario en uso en la parte se SESSION*/
                    try {
                        $query = $connection->prepare('SELECT * FROM users WHERE id_user = :id_user');
                        $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
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

                        $_SESSION["id_user"] = $user->getId();
                        $_SESSION["username"] = $user->getUsername();
                        $_SESSION["rating"] = $user->getRating();
                        $_SESSION["type"] = $user->getType();
                    }
                    catch(PDOException $e) {
                        echo $e;
                    }

                    header('Location: http://localhost/red-it/views/index.php');
                    exit();
                }
            }
            catch(PDOException $e) {
                $_SESSION['message'] = "Voto duplicado para un mismo Post";
                header('Location: http://localhost/red-it/views/index.php');
                //echo $e;
                exit();
            }

        }
        else{
            $_SESSION['message'] = "Faltan recibir datos del POST";
            header('Location: http://localhost/red-it/views/index.php');
            exit();
        }

    }
    else if ($_POST["_method"] === "Vote_Comment"){

        session_start();

        if(array_key_exists("id_comment", $_POST) && array_key_exists("value", $_POST) && array_key_exists("id_user", $_SESSION) ){

            $id_user = $_SESSION["id_user"];
            $id_comment = $_POST["id_comment"];
            $value = $_POST["value"];

            try {
                $query = $connection->prepare('INSERT INTO comment_votes VALUES(:id_comment, :id_user, :value)');
                $query->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                $query->bindParam(':value', $value, PDO::PARAM_INT);
           
                $query->execute();
         
                if($query->rowCount() === 0) {
                    $_SESSION['message'] = "Error en la inserción";
                    header('Location: http://localhost/red-it/views/index.php');
                    exit();
                }
                else{
                    //Insercion exitoso

                    /*Actualizar rating de usuario en uso en la parte se SESSION*/
                    try {
                        $query = $connection->prepare('SELECT * FROM users WHERE id_user = :id_user');
                        $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
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

                        $_SESSION["id_user"] = $user->getId();
                        $_SESSION["username"] = $user->getUsername();
                        $_SESSION["rating"] = $user->getRating();
                        $_SESSION["type"] = $user->getType();
                    }
                    catch(PDOException $e) {
                        echo $e;
                    }

                    header('Location: http://localhost/red-it/views/index.php');
                    exit();
                }
            }
            catch(PDOException $e) {
                $_SESSION['message'] = "Voto duplicado para un mismo Comentario";
                header('Location: http://localhost/red-it/views/index.php');
                exit();
            }

        }
        else{
            $_SESSION['message'] = "Faltan recibir datos del POST";
            header('Location: http://localhost/red-it/views/index.php');
            exit();
        }

    }

}
else if($_SERVER["REQUEST_METHOD"] === "GET"){

    if ($_GET["_method"] === "PostVotes"){
        if (array_key_exists("id_post", $_GET)){

        try{
            $id_post = $_GET["id_post"];

            $query = $connection->prepare('SELECT * FROM post_votes WHERE id_post = :id_post');
            $query->bindParam(':id_post', $id_post, PDO::PARAM_INT);
            $query->execute();
    
            $post_votes = array();;
    
            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $post_vote = new Post_Vote($row['id_post'], $row['id_user'], $row['value']);
                $post_votes[] = $post_vote->getArray();
            }
    
            echo json_encode($post_votes); //response text
        }
        catch(PDOException $e){
            $_SESSION['message'] = "Error en la recuperación de GET post_votes";
            header('Location: http://localhost/red-it/views/index.php');
            exit();
            }
        }
    }
    else if ($_GET["_method"] === "CommentVotes"){
        if (array_key_exists("id_comment", $_GET)){

            try{
                $id_comment = $_GET["id_comment"];
    
                $query = $connection->prepare('SELECT * FROM comment_votes WHERE id_comment = :id_comment');
                $query->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
                $query->execute();
        
                $comment_votes = array();;
        
                while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    $comment_vote = new Comment_Vote($row['id_comment'], $row['id_user'], $row['value']);
                    $comment_votes[] = $comment_vote->getArray();
                }
        
                echo json_encode($comment_votes); //response text
            }
            catch(PDOException $e){
            $_SESSION['message'] = "Error en la recuperación de GET comment_votes";
            header('Location: http://localhost/red-it/views/index.php');
            exit();
            }
        }
    }
}