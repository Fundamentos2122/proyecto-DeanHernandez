<div class="error" id="error">
<p>Mensaje de Prueba</p>
</div>



<script>
function MostrarError(){
    <?php 
    if(empty($_SESSION)){
        session_start();
    } 
    ?>
    var errorString = <?php echo json_encode($_SESSION['message']); ?>;
    document.getElementById("error").innerHTML = errorString;
    error.classList.add("show");
}
</script>