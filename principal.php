<?php

//require("cabecalho.php"); // diference entre require e include se der erro ele para no erro nao msotra os comando sequentes
//require_once nao inclui duas vez se eu fazer duas vezes a inclusao do mesmo arquivo
require_once("cabecalho.php");

?>

<main class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="text-center">
        <img src="tema.jpeg" alt="Imagem centralizada" class="img-fluid">
    </div>
</main>

<?php
require_once("rodape.php");
?>