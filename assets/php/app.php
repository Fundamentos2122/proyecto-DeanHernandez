
<script>
const postList = document.getElementById("post-list"); //Recupera el div que va a contener los posts
const modalPost = document.getElementById("modalPost"); //modal del post a visualizar
const modalPostComments = document.getElementById("modalPostComments"); //dentro del modal del post el div que contiene los comentarios del post
const modalMain = document.getElementById("modalMain");
const modalEdit = document.getElementById("modalEdit");
const modalEditContent = document.getElementById("modalEditContent");
//const keyList = "postlist";
//const keyList2 = "commentlist"; 


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

    for(var i = 0; i < list.length; i++) 
    {

        if(list[i].active === 1 && list[i].id_user === <?php echo $_SESSION["id_user"];?>)
        {

            html += 
            `<div class="Post" id="${list[i].id_post}" type="image">
            
            <form action="../controllers/postsController.php" method="POST" autocomplete="off cass="flow" enctype="multipart/form-data">
            <div>
                <input type="hidden" name="_method" value="Delete_Post">
                <input type="hidden" name="id_post" value="${list[i].id_post}">
                <input type="submit" value="X" class="btn-delete">
            </div>
            </form>

            <div>
                <button onclick="editPost(${list[i].id_post});">Edit</button>
            </div>

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
        else if(list[i].active === 1)
        {

            html += 
            `<div class="Post" id="${list[i].id_post}" type="image">
            
            <form action="../controllers/postsController.php" method="POST" autocomplete="off cass="flow" enctype="multipart/form-data">
            <div>
                <input type="hidden" name="_method" value="Delete_Post">
                <input type="hidden" name="id_post" value="${list[i].id_post}">
                <input type="submit" value="X" class="btn-delete">
            </div>
            </form>

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

    postList.innerHTML = html;

    //Si la sesion no es de tipo administrador oculta la funcion de borrar posts
    <?php
            if($_SESSION["type"] !== "administrador"){
                //echo  "hideDeletePost();";      
                echo "hideDelete();";            
            }
    ?>
}

function viewPost(id_post) {
    let xhttp = new XMLHttpRequest();

    xhttp.open("GET", "../controllers/postsController.php?id_post=" + id_post, true);

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                let post = JSON.parse(this.responseText);
                console.log(post);

        let html = '';

        html = 
            `<div class="Post" id="${post.id_post}" type="image">
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

    let html = '';

    for(var i = 0; i < list.length; i++) {

        
        if(list[i].active === 1)
        {

        html += 

            `
        <div class="Comment" id="${list[i].id_comment}">
            <p>${list[i].id_comment}</p>
        
            <form action="../controllers/commentsController.php" method="POST" autocomplete="off cass="flow" enctype="multipart/form-data">
            <div>
                <input type="hidden" name="_method" value="Delete_Comment">
                <input type="hidden" name="id_comment" value="${list[i].id_comment}">
                <input type="submit" value="X" class="btn-delete">
            </div>
            </form>

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
        
        modalPostComments.innerHTML = html;
        }
    }

    modalPostComments.innerHTML = html;

    //Si la sesion no es de tipo administrador oculta la funcion de borrar comentarios
    <?php
            if($_SESSION["type"] !== "administrador"){
                //echo  "hideDeleteComment();";     
                echo "hideDelete();";           
            }
    ?>

    modalMain.classList.add("show");

}

function hideDelete(){
    let btnDelete = document.querySelectorAll("input[value='X']");
    btnDelete.forEach(input => input.remove());
}

function editPost(id_post) {
    let xhttp = new XMLHttpRequest();

    xhttp.open("GET", "../controllers/postsController.php?id_post=" + id_post, true);

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                let post = JSON.parse(this.responseText);
                console.log(post);

        let html = '';

        html = 

        `  
        <div class="PostEdit" id="${post.id_post}" type="image">
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
                <div id="pi">   
                <img src=\"data:image/jpeg;base64,${post.photo}"\" alt=\"\" class=\"img-fluid\">
                </div>
         </div>

         <div>

        <form action="../controllers/postsController.php" method="POST" autocomplete="off" class="flow" enctype="multipart/form-data"> 
        
        <div id="Post" class="tabcontent">
            <h3 style="text-align: center;">Post</h3>
            <div>
                <input type="text" id="post-title" name="title" placeholder="*Ingresar el titulo del Post (Obligatorio)" value="${post.title}">
            </div>
            <br>
            <div>
                <textarea id="Post-description" name="text" rows="30" placeholder="Descripción del post">${post.text}</textarea>
            </div>
        </div>

        <div id="Imagen" class="tabcontent">
            <h3 style="text-align: center;">Imagen</h3>
            <br>
            <p>Subir un imagen: </p>
            <br>
            <input type="file" id="photo" name="photo" onchange="readURL(this);">
            <img id="post-img" src="#" alt="">
            <div>
                <button type="submit">Subir Post</button>
            </div>
            <input type="hidden" name="_method" value="Update_Post">
            <input type="hidden" name="id_post" value="${post.id_post}">
        </div>

        </form>
                `;

                modalEditContent.innerHTML = html;

                modalEdit.classList.add("show");

            }
            else {
                console.log("Error");
            }
        }
    };

    xhttp.send();
}

</script>