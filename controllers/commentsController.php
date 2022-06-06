<?php 

include("../models/DB.php");
include("../models/Comment.php");

//var_dump($_POST);
//var_dump($_SESSION);

try {
    $connection = DBConnection::getConnection();
}
catch(PDOException $e) {
    error_log("Error de conexión - " . $e, 0);

    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){

    if ($_POST["_method"] === "Create_Comment"){

        session_start();

        if(array_key_exists("text", $_POST) && array_key_exists("id_post", $_POST) && array_key_exists("id_user", $_SESSION) && array_key_exists("username", $_SESSION)){

            if($_POST["text"] === "")
            {
            $_SESSION['message'] = "No introduciste texto";
            header('Location: http://localhost/red-it/views/index.php');
            exit();
            }

            $id_user = $_SESSION["id_user"];
            $username = $_SESSION["username"];
            $text = $_POST["text"];
            $id_post = $_POST["id_post"];
            $rating = 0;
            $created_at = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
            $updated_at = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
            $active = 1;

            try {
                $query = $connection->prepare('INSERT INTO comments VALUES(NULL, :id_user, :username, :id_post, :text, :rating, :created_at, :updated_at, :active)');
                 $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                 $query->bindParam(':username', $username, PDO::PARAM_STR);
                 $query->bindParam(':id_post', $id_post, PDO::PARAM_INT);
                 $query->bindParam(':text', $text, PDO::PARAM_STR);
                 $query->bindParam(':rating', $rating, PDO::PARAM_INT);
                 $query->bindParam(':created_at', $created_at, PDO::PARAM_STR);
                 $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
                 $query->bindParam(':active', $active, PDO::PARAM_INT);
                 
                 $query->execute();
         
                 if($query->rowCount() === 0) {
                     echo "Error en la inserción";
                     exit();
                 }
                 else {
                     header('Location: http://localhost/red-it/views/index.php');
                     exit();
                 }
             }
             catch(PDOException $e) {
                 echo $e;
                 exit();
              }

        }
        else{
            echo "faltan recibir datos del comentario";
            exit();
        }

    }else if ($_POST["_method"] === "Delete_Comment"){

        if(array_key_exists("id_comment", $_POST)){
            $id_comment = $_POST["id_comment"];

            try{
                $query = $connection->prepare('UPDATE comments SET active = 0 WHERE id_comment = :id_comment');
                $query->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
                $query->execute();

                if($query->rowCount() === 0) {
                    $_SESSION['message'] = "Error en la actualización";
                    header('Location: http://localhost/red-it/views/index.php');
                    exit();
                }
                else{
                    header('Location: http://localhost/red-it/views/index.php');
                     exit();
                }
            }catch(PDOException $e){
                echo $e;
                exit();
            }

        }
    }

}
else if($_SERVER["REQUEST_METHOD"] === "GET"){
    if (array_key_exists("id_post", $_GET)) {
        //Obtener los comentarios de un solo Post
        try {
            $id_post = $_GET["id_post"];

            $query = $connection->prepare('SELECT * FROM comments WHERE id_post = :id_post');
            $query->bindParam(':id_post', $id_post, PDO::PARAM_INT);
            $query->execute();
    
            $comments = array();;
    
            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $comment = new Comment($row['id_comment'], $row['id_user'], $row['username'], $row['id_post'], $row['text'], $row['rating'],  $row['created_at'], $row['updated_at'], $row['active']);
                $comments[] = $comment->getArray();
            }
    
            echo json_encode($comments); //response text
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
}