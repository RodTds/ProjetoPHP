<?php

//require("cabecalho.php"); // diference entre require e include se der erro ele para no erro nao msotra os comando sequentes
//require_once nao inclui duas vez se eu fazer duas vezes a inclusao do mesmo arquivo

require_once("cabecalho.php");
echo "<h2>Usuario: " . $_SESSION['usuario'] . "</h2>";
?>

<?php
require_once("rodape.php");
?>