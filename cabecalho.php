<?php
session_start();
if (!$_SESSION['acesso']) {
    header('location: index.php?mensagem=acesso_negado');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema ONG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="principal.php">MENU DE CADASTRO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> <!--Esse button e quando diminui aparece menuzinho-->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="voluntarios.php">VOLUNTARIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="projetos.php">PROJETOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="atividades.php">ATIVIDADES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="agenda.php">AGENDA</a>
                    </li>
                    <li class="nav-item">
                        <a id="btnSair" class="nav-link btn btn-danger" href="sair.php">Sair</a>
                        <!--SweetAlert-->
                        <!--Repositorio professora --  https://github.com/vanessaborges2/Eletiva-1-2025-->
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <main class="container">