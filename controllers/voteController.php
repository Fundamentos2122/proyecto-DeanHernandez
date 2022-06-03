<?php 

include("../models/DB.php");
include("../models/Post_Vote.php");
include("../models/Comment_Vote.php");
include("../models/Post.php");
include("../models/Comment.php");


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

        //echo $_POST["value"];
        //echo $_POST["id_post"];
        //echo $_SESSION["id_user"];
        //exit();

        if(array_key_exists("id_post", $_POST) && array_key_exists("value", $_POST) && array_key_exists("id_user", $_SESSION) ){

            $id_user = $_SESSION["id_user"];
            $id_post = $_POST["id_post"];
            $value = $_POST["value"];

            try {
                $query = $connection->prepare('INSERT INTO post_votes VALUES(:id_post, :id_user, :value)');
                $query->bindParam(':id_post', $id_post, PDO::PARAM_INT);
                $query->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                 $query->bindParam(':value', $value, PDO::PARAM_INT);
           
                 $query->execute();
         
                 if($query->rowCount() === 0) {
                     echo "Error en la inserción";
                     exit();
                 }
                 else {

                    
                    try{
                        $q = $connection->prepare('SELECT SUM(value) AS total_rating FROM post_votes WHERE id_post = :id_post');
                        $q->bindParam(':id_post', $id_post, PDO::PARAM_INT);
                        $q->execute();
            
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        $total_rating = $row['total_rating'];
                        
                        echo $total_rating;
                        //exit();

                        try {
   
                            $query = $connection->prepare('UPDATE posts SET rating = :total_rating WHERE id_post = :id_post');
                            $query->bindParam(':total_rating', $total_rating, PDO::PARAM_INT);
                            $query->bindParam(':id_post', $id_post, PDO::PARAM_INT);
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
                        catch(PDOException $e){
                            echo $e;
                            exit();
                        }

                     header('Location: http://localhost/red-it/views/index.php');
                    }
                }
             catch(PDOException $e) {
                 //echo $e;
                 echo "Voto duplicado para un mismo post (Conflicto UNIQUE KEY)";
                 exit();
              }

        }
        else{
            echo "faltan recibir datos del POST";
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
                     echo "Error en la inserción";
                     exit();
                 }
                 else {


                    try{
                        $q = $connection->prepare('SELECT SUM(value) AS total_rating FROM comment_votes WHERE id_comment = :id_comment');
                        $q->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
                        $q->execute();
            
                        $row = $q->fetch(PDO::FETCH_ASSOC);
                        $total_rating = $row['total_rating'];
                        
                        echo $total_rating;
                        //exit();

                        try {
   
                            $query = $connection->prepare('UPDATE comments SET rating = :total_rating WHERE id_comment = :id_comment');
                            $query->bindParam(':total_rating', $total_rating, PDO::PARAM_INT);
                            $query->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
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
                        catch(PDOException $e){
                            echo $e;
                            exit();
                        }


                     header('Location: http://localhost/red-it/views/index.php');
                 }
             }
             catch(PDOException $e) {
                 echo $e;
                 exit();
              }

        }
        else{
            echo "faltan recibir datos del POST";
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
            echo $e;
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
                echo $e;
                exit();
            }
        }
    }
}