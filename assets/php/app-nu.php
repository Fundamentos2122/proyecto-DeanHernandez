<script>
const postList = document.getElementById("post-list"); //Recupera el div que va a contener los posts
const modalPost = document.getElementById("modalPost"); //modal del post a visualizar
const modalPostComments = document.getElementById("modalPostComments"); //dentro del modal del post el div que contiene los comentarios del post
const modalMain = document.getElementById("modalMain");
const keyList = "postlist";
const keyList2 = "commentlist"; //Funciona en conjunto con ModalPostComments


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

    xhttp.open("GET", "controllers/postsController.php", true);

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

    for(var i = 0; i < list.length; i++) {

    if(list[i].active === 1){
        html += 
            `<div class="Post" id="${list[i].id_post}" type="image">
            <div class="Rating-box">
                <p class="up-arrow">&#9650;</p>
                <p class="rating-number">${list[i].rating}</p>
                <p class="down-arrow">&#9660;</p>
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
    }   

    postList.innerHTML = html;
}

function viewPost(id_post) {
    let xhttp = new XMLHttpRequest();

    xhttp.open("GET", "controllers/postsController.php?id_post=" + id_post, true);

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                let post = JSON.parse(this.responseText);
                console.log(post);

        //modalPost.classList.add("show");

        let html = '';

        html = 
            `<div class="Post" id="${post.id_post}" type="image">
            <div class="Rating-box">
                <p class="up-arrow">&#9650;</p>
                <p class="rating-number">${post.rating}</p>
                <p class="down-arrow">&#9660;</p>
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
                `;
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

    xhttp.open("GET", "controllers/commentsController.php?id_post=" + id_post, true);

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

        if(list[i].active === 1){

        html += 
            `

        <div class="Comment" id="${list[i].id_comment}">
            <div class="cmt-img">
            <img src="resources/images/red-it_logo.png" alt=""></a>
            </div>
            <div class="Rating-box">
                <p class="up-arrow">&#9650;</p>
                <p class="rating-number">${list[i].rating}</p>
                <p class="down-arrow">&#9660;</p>
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
    }

    modalPostComments.innerHTML = html;

    modalMain.classList.add("show");

}

</script>