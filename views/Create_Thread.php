<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Thread</title>
    <link rel="stylesheet" href="../assets/css/Create_Thread_style.css">

    <!-- api para visualizar imagen antes de subir en tab de Imagen/Video -->
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    
</head>
<body>
    <header>
    <?php include("layouts/header.php")?>
    <p id="Create-post_Header">Create Post</p>
    </header>

    <section>
        <br>
    <h2>Detalles del Post: </h2>
        <br>

<div class="tab">
  <button class="tablinks" onclick="openTab(event, 'Post')">Post</button>
  <button class="tablinks" onclick="openTab(event, 'Imagen')">Imagen</button>
</div>

<form action="../controllers/postsController.php" method="POST" autocomplete="off" class="flow" enctype="multipart/form-data"> <!-- inicio del form para post-->

<div id="Post" class="tabcontent">
  <h3 style="text-align: center;">Post</h3>
    <div>
        <input type="text" id="post-title" name="title" placeholder="*Ingresar el titulo del Post (Obligatorio)">
    </div>
    <br>
    <div>
        <textarea id="Post-description" name="text" rows="30" placeholder="Descripción del post"></textarea>
    </div>

    <div>
        <button type="submit">Subir Post</button>
    </div>
</div>

<div id="Imagen" class="tabcontent">
  <h3 style="text-align: center;">Imagen</h3>
  <br>
  <p>Subir un imagen: </p>
  <br>

    <input type="file" id="photo" name="photo" onchange="readURL(this);">
    <img id="post-img" src="#" alt="">
    
    <!-- //Metodo #1
    <input type='file' onchange="readURL(this);" />
    <img id="post-img-vid" src="#" alt="" />
    -->

    <!-- //Metodo #2
    <input type="file" onchange="previewFile()"><br>
    <img src="" height="200" alt="Vista previa...">
    -->

    <!-- //Metodo #3
        
        <select ng-model='option'>
    <option value='image'>Image</option>
    <option value='video'>Video</option>
    </select>

    <img class="cat-img" src="image path" style="width: 100px;margin: 10px 0px;" ng-if="option=='image'"> 

    <video width="320" controls> <source src="videopath" type="video/mp4" ng-if="option=='video'"></video>
    -->

    
    <div>
        <button type="submit">Subir Post</button>
    </div>

    <input type="hidden" name="_method" value="Create_Post">
</div>

</form>
    </section>

    <footer>
        <p>Hernandez Dean Joshua © 2022</p>
    </footer>
    <script src="../assets/js/Create_Thread.js"></script>
</body>
</html>