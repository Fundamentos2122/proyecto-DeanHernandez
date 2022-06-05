<?php 

include("../models/DB.php");
include("../models/Post.php");

//var_dump($_POST);
//var_dump($_SESSION);
//var_dump($_FILES);

try {
    $connection = DBConnection::getConnection();
}
catch(PDOException $e) {
    error_log("Error de conexión - " . $e, 0);

    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Postear... un post
    if ($_POST["_method"] === "Create_Post"){
        
        session_start();

        //foreach ($_POST as $key => $value){
        //    echo "$key = $value <br>";}

        //exit();

        if(array_key_exists("title", $_POST) && array_key_exists("id_user", $_SESSION) && array_key_exists("username", $_SESSION))
        {
            if($_POST["title"] === "")
            {
                $_SESSION['message'] = "No introduciste un Titulo";
                header('Location: http://localhost/red-it/views/Create_Thread.php');
                exit();
            }

            try{

                $id_user = $_SESSION["id_user"];
                $username = $_SESSION["username"];
                $text = $_POST["text"];
                $title = $_POST["title"];
                $photo = "";
                $rating = 0;
                $created_at = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
                $updated_at = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);

                //Si el tamaño de la foto es mayor a 0...
                if ($_FILES["photo"]["size"] > 0) { 
                    $tmp_name = $_FILES["photo"]["tmp_name"];
                    $photo = file_get_contents($tmp_name);
                }

                try {
                    $query = $connection->prepare('INSERT INTO posts VALUES(NULL, :id_user, :username, :text, :title, :photo, :rating, :created_at, :updated_at)');
                    $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                    $query->bindParam(':username', $username, PDO::PARAM_STR);
                    $query->bindParam(':text', $text, PDO::PARAM_STR);
                    $query->bindParam(':title', $title, PDO::PARAM_STR);
                    $query->bindParam(':photo', $photo, PDO::PARAM_STR);
                    $query->bindParam(':rating', $rating, PDO::PARAM_INT);
                    $query->bindParam(':created_at', $created_at, PDO::PARAM_STR);
                    $query->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);
         
                    $query->execute();
 
                    if($query->rowCount() === 0) {
                        $_SESSION['message'] = "Error en la inserción";
                        header('Location: http://localhost/red-it/views/Create_Thread.php');
                        exit();
                    }
                    else{
                        header('Location: http://localhost/red-it/views/index.php');
                        exit();
                    }
                }
                catch(PDOException $e) {
                    $_SESSION['message'] = "Error en la inserción";
                    header('Location: http://localhost/red-it/views/Create_Thread.php');
                    exit();
                }

                header('Location: http://localhost/red-it/views/index.php');
            }
            catch(PDOException $e)
            {
                echo $e;
                exit();
            }
        }
        else{
            echo "Datos no encontrados";
            exit();
        }

    }
    /*else{
        //if($_POST["_method"] === "Update_Post")
        //if(array_key_exists("id_post", $_POST)){

            try{
            $q = $connection->prepare('SELECT SUM(value) AS total_rating FROM post_votes WHERE id_post = :id_post');
            $q->bindParam(':id_post', $id_post, PDO::PARAM_INT);
            $q->execute();

            $row = $q->fetch(PDO::FETCH_ASSOC);
            $total_rating = $row['total_rating'];
            
            echo $total_rating;
            echo json_encode($total_rating); //response text
            }
            catch(PDOException $e){
                echo $e;
                exit();
            }

        //}
       // else{
            //echo "No se recibio un id_post correcto";
           // exit();
        //}
    }*/

}
else if($_SERVER["REQUEST_METHOD"] === "GET"){
    if (array_key_exists("id_post", $_GET)) {
        //Obtener un solo registro/post
        try {
            $id_post = $_GET["id_post"];

            $query = $connection->prepare('SELECT * FROM posts WHERE id_post = :id_post');
            $query->bindParam(':id_post', $id_post, PDO::PARAM_INT);
            $query->execute();
    
            $post;
    
            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $post = new Post($row['id_post'], $row['id_user'], $row['username'], $row['text'], $row['title'], $row['photo'], $row['rating'],  $row['created_at'], $row['updated_at']);
            }
    
            echo json_encode($post->getArray()); //response text
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
    else {
        //Obtener TODOS los registros, llamado por getPosts(); en app.php
        session_start();

        try {
            $query_string = 'SELECT * FROM posts';
            $query = $connection->prepare($query_string);
            $query->execute();
    
            $posts = array();
    
            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $post = new Post($row['id_post'], $row['id_user'], $row['username'], $row['text'], $row['title'], $row['photo'], $row['rating'],  $row['created_at'], $row['updated_at']);
                $posts[] = $post->getArray();
            }
    
            echo json_encode($posts); //response text
        }
        catch(PDOException $e) {
            echo $e;
        }
    }
}

?>