//Seleccionar un determinado Tab
function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
  }

  //Mostrar archivo -> img/video metodo #1
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#post-img-vid')
          .attr('src', e.target.result)
          //.width(150)
          .height(200);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  //Mostrar img metodo #2
  function previewFile() {
    var preview = document.querySelector('img');
    var file    = document.querySelector('input[type=file]').files[0];
    var reader  = new FileReader();
  
    reader.onloadend = function () {
      preview.src = reader.result;
    }
  
    if (file) {
      reader.readAsDataURL(file);
    } else {
      preview.src = "";
    }
  }

  //Iniciar la pagina abriendo el tab de Post
  openTab(event, 'Post');

  //2da manera de realizar lo de arriba
  //document.getElementById("defaultOpen").click();
