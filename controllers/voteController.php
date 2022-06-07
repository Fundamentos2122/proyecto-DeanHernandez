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

                /*$query = $connection->prepare('SELECT SUM(value) AS total_rating FROM post_votes WHERE id_post = :id_post');
                $query->bindParam(':id_post', $id_post, PDO::PARAM_INT);
                $query->execute();

                $row = $query->fetch(PDO::FETCH_ASSOC);

                //foreach ($row as $key => $value){
                //echo "$key = $value <br>";}

                //echo $row["total_rating"];

                $fin = $row["total_rating"];

                echo $fin;

                exit();
                die();*/

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

                    try{
                        //Actualizar rating total del post afectado (funcionando)
                        $sumQ = $connection->prepare('SELECT SUM(value) AS total_rating FROM post_votes WHERE id_post = :id_post');
                        $sumQ->bindParam(':id_post', $id_post, PDO::PARAM_INT);
                        $sumQ->execute();

                        $row = $sumQ->fetch(PDO::FETCH_ASSOC);
                        $total_rating = $row["total_rating"];

                        $query2 = $connection->prepare('UPDATE posts SET rating = :total_rating WHERE id_post = :id_post');
                        $query2->bindParam(':id_post', $id_post, PDO::PARAM_INT);
                        $query2->bindParam(':total_rating', $total_rating, PDO::PARAM_INT);
                        $query2->execute();

                        //Update affected user total rating...
                        //SELECT AFFECTED USER FROM VOTED POST (recover id_user from the post)

                        $AffU = $connection->prepare('SELECT id_user FROM posts WHERE id_post = :id_post');
                        $AffU->bindParam(':id_post', $id_post, PDO::PARAM_INT);
                        $AffU->execute();
            
                        if ($AffU->rowCount() === 0) {
                            $_SESSION['message'] = "Post no encontrado";
                            header('Location: http://localhost/red-it/views/index.php');
                            exit();
                        }

            
                        $row = $AffU->fetch(PDO::FETCH_ASSOC);
                        $Affected_user = $row["id_user"];

                        //echo $Affected_user;
                        //exit();
                        //die();
                        

                        //SELECT SUM(rating) FROM posts WHERE id_user = :id_user

                        $sumP = $connection->prepare('SELECT SUM(rating) AS posts_rating FROM posts WHERE id_user = :Affected_user');
                        $sumP->bindParam(':Affected_user', $Affected_user, PDO::PARAM_INT);
                        $sumP->execute();

                        $row = $sumP->fetch(PDO::FETCH_ASSOC);
                        $posts_rating = $row["posts_rating"];

                        //SELECT SUM(rating) FROM comments WHERE id_user = :id_user

                        $sumC = $connection->prepare('SELECT SUM(rating) AS comments_rating FROM comments WHERE id_user = :Affected_user');
                        $sumC->bindParam(':Affected_user', $Affected_user, PDO::PARAM_INT);
                        $sumC->execute();

                        $row = $sumC->fetch(PDO::FETCH_ASSOC);
                        $comments_rating = $row["comments_rating"];

                        //Make total_UserRating from last 2

                        $total_UserRating = $posts_rating + $comments_rating;

                        //$query3 = $connection->prepare('UPDATE users SET rating = ');
                        //$query3->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                        //$query3->execute();*/

                        //$query3 = $connection->prepare('UPDATE users SET rating = (SELECT (SELECT SUM(rating) FROM posts WHERE id_user = :id_user) + (SELECT SUM(rating) FROM comments WHERE id_user = :id_user) AS total_rating)');
                        //$query3->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                        //$query3->execute();*/

                        //Define Affected_user and total_UserRating
                        $query3 = $connection->prepare('UPDATE users SET rating = :total_UserRating WHERE id_user = :Affected_user');
                        $query3->bindParam(':Affected_user', $Affected_user, PDO::PARAM_INT);
                        $query3->bindParam(':total_UserRating', $total_UserRating, PDO::PARAM_INT);
                        $query3->execute();


                    }catch(PDOException $e){
                        echo $e;
                        exit();
                    }

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
                        exit();
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

                    try{
                        //Hacer suma de todos los votos de comentarios que califican al comentario calificado
                        $sumQ = $connection->prepare('SELECT SUM(value) AS total_rating FROM comment_votes WHERE id_comment = :id_comment');
                        $sumQ->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
                        $sumQ->execute();

                        $row = $sumQ->fetch(PDO::FETCH_ASSOC);
                        $total_rating = $row["total_rating"];

                        //Insertar en el comentario el nuevo total de rating despues de ser calificado
                        $query2 = $connection->prepare('UPDATE comments SET rating = :total_rating WHERE id_comment = :id_comment');
                        $query2->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
                        $query2->bindParam(':total_rating', $total_rating, PDO::PARAM_INT);
                        $query2->execute();

                        //Update affected user total rating...
                        //SELECT AFFECTED USER FROM VOTED COMMENT (recover id_user from the comment)

                        $AffU = $connection->prepare('SELECT id_user FROM comments WHERE id_comment = :id_comment');
                        $AffU->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
                        $AffU->execute();
            
                        if ($AffU->rowCount() === 0) {
                            $_SESSION['message'] = "Usuario no encontrado para actualizar";
                            header('Location: http://localhost/red-it/views/index.php');
                            exit();
                        }

                        $row = $AffU->fetch(PDO::FETCH_ASSOC);
                        $Affected_user = $row["id_user"];

                        //echo $Affected_user;
                        //exit();
                        //die();
                        

                        //SELECT SUM(rating) FROM posts WHERE id_user = :id_user

                        $sumP = $connection->prepare('SELECT SUM(rating) AS posts_rating FROM posts WHERE id_user = :Affected_user');
                        $sumP->bindParam(':Affected_user', $Affected_user, PDO::PARAM_INT);
                        $sumP->execute();

                        $row = $sumP->fetch(PDO::FETCH_ASSOC);
                        $posts_rating = $row["posts_rating"];

                        //echo $row["posts_rating"];
                        //echo $posts_rating;
                        //exit();
                        //die();

                        //SELECT SUM(rating) FROM comments WHERE id_user = :id_user

                        $sumC = $connection->prepare('SELECT SUM(rating) AS comments_rating FROM comments WHERE id_user = :Affected_user');
                        $sumC->bindParam(':Affected_user', $Affected_user, PDO::PARAM_INT);
                        $sumC->execute();

                        $row = $sumC->fetch(PDO::FETCH_ASSOC);
                        $comments_rating = $row["comments_rating"];

                        //Make total_UserRating from last 2

                        $total_UserRating = $posts_rating + $comments_rating;

                        //$query3 = $connection->prepare('UPDATE users SET rating = ');
                        //$query3->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                        //$query3->execute();*/

                        //$query3 = $connection->prepare('UPDATE users SET rating = (SELECT (SELECT SUM(rating) FROM posts WHERE id_user = :id_user) + (SELECT SUM(rating) FROM comments WHERE id_user = :id_user) AS total_rating)');
                        //$query3->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                        //$query3->execute();*/

                        //Define Affected_user and total_UserRating
                        $query3 = $connection->prepare('UPDATE users SET rating = :total_UserRating WHERE id_user = :Affected_user');
                        $query3->bindParam(':Affected_user', $Affected_user, PDO::PARAM_INT);
                        $query3->bindParam(':total_UserRating', $total_UserRating, PDO::PARAM_INT);
                        $query3->execute();

                    }catch(PDOException $e){
                        echo $e;
                        exit();
                    }

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
                        exit();
                    }

                    header('Location: http://localhost/red-it/views/index.php');
                    exit();
                }
            }
            catch(PDOException $e) {
                $_SESSION['message'] = "Voto duplicado para un mismo Comentario";
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