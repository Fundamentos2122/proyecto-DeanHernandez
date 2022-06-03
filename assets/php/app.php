
<script>
const postList = document.getElementById("post-list"); //Recupera el div que va a contener los posts
const modalPost = document.getElementById("modalPost"); //modal del post a visualizar
const modalPostComments = document.getElementById("modalPostComments"); //dentro del modal del post el div que contiene los comentarios del post
const modalMain = document.getElementById("modalMain");
//const keyList = "postlist";
//const keyList2 = "commentlist"; //Funciona en conjunto con ModalPostComments


document.addEventListener("DOMContentLoaded", function() {

    getPosts();

    let modals = document.getElementsByClassName("modal");

    for(var i = 0; i < modals.length; i++) {
        modals[i].addEventListener("click", function(e) {
            if(e.target === this){
                this.classList.remove("show");
            }
        });
    }

});

function getPosts() {

    let xhttp = new XMLHttpRequest();

    xhttp.open("GET", "../controllers/postsController.php", true);

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            console.log(this.status);
            if (this.status === 200) {
                let list = JSON.parse(this.responseText);
                paintPosts(list);
            }
            else {
                console.log("Error");
            }
        }
    };
    
    xhttp.send();

    return [];
}

function paintPosts(list) {
    let html = '';

    //Sustituir con esta implementacion, agregar active an tabla
    <?php
            if($_SESSION["type"] !== "administrador"){
                //echo  "hideDelete();";                
            }
    ?>

    for(var i = 0; i < list.length; i++) {

        html += 
            `<div class="Post" id="${list[i].id_post}" type="image">
            <?php
           //session_start();
           if($_SESSION["type"] === "administrador"){
                echo  ('

                <div><input type="submit" value="X"><br/></div>
                
                ');     
            }
            ?>
            <div class="Rating-box">
            <form action="../controllers/voteController.php" method="POST" autocomplete="off" class="flow" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="Vote_Post">
                <input type="hidden" name="value" value="1">
                <input type="hidden" name="id_post" value="${list[i].id_post}">
                <input type="submit" class="up-arrow" value="&#9650">
            </form>
                <p class="rating-number">${list[i].rating}</p>
            <form action="../controllers/voteController.php" method="POST" autocomplete="off" class="flow" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="Vote_Post">
                <input type="hidden" name="value" value="-1">
                <input type="hidden" name="id_post" value="${list[i].id_post}">
                <input type="submit" class="down-arrow" value="&#9660">
            </form>
            </div>
            <div>
                <div class="user-date_box">
                    <p class="username">${list[i].username}</p>
                    <p class="uploadtime">${list[i].created_at}</p>
                </div>
                <div class="title-box">
                    <p class="Post-title">${list[i].title}</p>
                </div>
                <div class="text-box">
                    <p class="Post-text">${list[i].text}</p>
                </div>
                <div class="Post-Image">   
                <img src=\"data:image/jpeg;base64,${list[i].photo}"\" alt=\"\" class=\"img-fluid\">
                </div>
                <div class="Comment-box">
                <button class="Post_viewlink" onclick="viewPost(${list[i].id_post})"> Visitar Hilo</p>
                </div>
            </div>
        </div>`;
    }

    postList.innerHTML = html;
}

function viewPost(id_post) {
    let xhttp = new XMLHttpRequest();

    xhttp.open("GET", "../controllers/postsController.php?id_post=" + id_post, true);

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                let post = JSON.parse(this.responseText);
                console.log(post);

        //modalPost.classList.add("show");

        let html = '';

        //<div class="Comment-box">
        //<button class="Post_viewlink" onclick="viewPost(${list[i].id_post})"> Visitar Hilo</p>
        //</div> 

        html = 
            `<div class="Post" id="${post.id_post}" type="image">
            
            <?php
           //session_start();
           if($_SESSION["type"] === "administrador"){
                echo  ('

                <div><input type="submit" value="X"><br/></div>
                
                ');     
            }
            ?>
            
            <div class="Rating-box">
            <form action="../controllers/voteController.php" method="POST" autocomplete="off" class="flow" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="Vote_Post">
                <input type="hidden" name="value" value="1">
                <input type="hidden" name="id_post" value="${post.id_post}">
                <input type="submit" class="up-arrow" value="&#9650">
            </form>
                <p class="rating-number">${post.rating}</p>
            <form action="../controllers/voteController.php" method="POST" autocomplete="off" class="flow" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="Vote_Post">
                <input type="hidden" name="value" value="-1">
                <input type="hidden" name="id_post" value="${post.id_post}">
                <input type="submit" class="down-arrow" value="&#9660">
            </form>
            </div>
            <div>
                <div class="user-date_box">
                    <p class="username">${post.username}</p>
                    <p class="uploadtime">${post.created_at}</p>
                </div>
                <div class="title-box">
                    <p class="Post-title">${post.title}</p>
                </div>
                <div class="text-box">
                    <p class="Post-text">${post.text}</p>
                </div>
                <div class="Post-Image">   
                <img src=\"data:image/jpeg;base64,${post.photo}"\" alt=\"\" class=\"img-fluid\">
                </div>
                <div class="Comment-form">
                <form action="../controllers/commentsController.php" method="POST">
                    <input type="hidden" name="_method" value="Create_Comment">
                    <input type="hidden" name="id_post" value="${post.id_post}">
                    <p>Comentar como: <?php echo $_SESSION["username"] ?> </p>
                    <input type="text" id="form-text" name="text">
                    <input type="submit" id="btnCmt" value="Subir comentario">
                </form>
        </div>`;
        //Reemplazar el comment box con los comentarios

                modalPost.innerHTML = html;

                getComments(id_post);

            }
            else {
                console.log("Error");
            }
        }
    };

    xhttp.send();
}

function getComments(id_post)
{
    let xhttp = new XMLHttpRequest();

    xhttp.open("GET", "../controllers/commentsController.php?id_post=" + id_post, true);

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            console.log(this.status);
            if (this.status === 200) {
                 let list = JSON.parse(this.responseText);
                 console.log(list);
               paintComments(list);
            }
            else {
               console.log("Error");
            }
        }
    };

    xhttp.send();

    return [];

}

function paintComments(list){

    //modalPostComments.classList.add("show");

    let html = '';

    for(var i = 0; i < list.length; i++) {

        html += 
            `

        <div class="Comment" id="${list[i].id_comment}">
            <p>${list[i].id_comment}</p>
            <?php
           //session_start();
           if($_SESSION["type"] === "administrador"){
                echo  ('

                <div><input type="submit" value="X"><br/></div>

                ');     
            }
            ?>
            <div class="cmt-img">
            <img src="../resources/images/red-it_logo.png" alt=""></a>
            </div>
            <div class="Rating-box">
            <form action="../controllers/voteController.php" method="POST" autocomplete="off" class="flow" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="Vote_Comment">
                <input type="hidden" name="value" value="1">
                <input type="hidden" name="id_comment" value="${list[i].id_comment}">
                <input type="submit" class="up-arrow" value="&#9650">
            </form>
                <p class="rating-number">${list[i].rating}</p>
            <form action="../controllers/voteController.php" method="POST" autocomplete="off" class="flow" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="Vote_Comment">
                <input type="hidden" name="value" value="-1">
                <input type="hidden" name="id_comment" value="${list[i].id_comment}">
                <input type="submit" class="down-arrow" value="&#9660">
            </form>
            </div>
            <div>
                <div class="user-date_box">
                <p class="username">${list[i].username}</p>
                <p class="uploadtime">${list[i].created_at}</p>
                </div>
                <div class="text-box">
                <p class="Post-text">${list[i].text}</p>
                </div>
            </div>
        </div> 

            `
    }

    modalPostComments.innerHTML = html;

    modalMain.classList.add("show");

}
/*
function updatePosts(){

    let xhttp = new XMLHttpRequest();

    xhttp.open("GET", "../controllers/postsController.php", true);

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            //console.log(this.status);
            if (this.status === 200) {
                let list = JSON.parse(this.responseText);
                updateP(list);
            }
            else {
                console.log("Error");
            }
        }
    };
    
    xhttp.send();

    //return [];

}

function updateP(list){

    let xhttp = new XMLHttpRequest();

    for(var i = 0; i < list.length; i++){

        xhttp.open("POST", "../controllers/postsController.php?id_post=" + list[i].id_post, true);

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4) {
                console.log(this.status);
                if (this.status === 200) {
                    let resp = JSON.parse(this.responseText);
                    console.log(this.responseText);
                 }
                else {
                    console.log("Error");
                 }
            }
    };

    xhttp.send();

    //return [];

    }

}*/

</script>