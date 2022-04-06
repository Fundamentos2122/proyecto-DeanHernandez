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

  //Mostrar img/video
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#post-img-vid')
          .attr('src', e.target.result)
          //.width(150)
          //.height(200);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  //Iniciar la pagina abriendo el tab de Post
  openTab(event, 'Post');
