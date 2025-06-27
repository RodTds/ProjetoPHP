<?php
ob_start(); // perguntar porque isso eliminou o problema na hora de 
// gravar no banco onde chama o header na pagina alterar_agendamento e colocar no final tb rodape.php
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
    <style>
        .navbar-metallic {
            background-color: #4f6d8c;
        }
    </style>

<body >
    <nav class="navbar navbar-expand-lg navbar-dark navbar-metallic">
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
                        <a class="nav-link active" aria-current="page" href="principal.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            VOLUNTÁRIO
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="voluntarios.php">Listar Voluntários</a></li>
                            <li><a class="dropdown-item" href="novo_voluntario.php">Novo Voluntário</a></li>
                            <li><a class="dropdown-item" href="pesquisar_voluntario.php">Pesquisar Voluntário</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            PROJETOS
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="projetos.php">Listar Projetos</a></li>
                            <li><a class="dropdown-item" href="novo_projeto.php">Novo Projeto</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            ATIVIDADES
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="atividades.php">Listar Atividades</a></li>
                            <li><a class="dropdown-item" href="nova_atividade.php">Nova Atividade</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            AGENDA
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="agenda.php">Listar Agendamentos</a></li>
                            <li><a class="dropdown-item" href="novo_agendamento.php">Novo Agendamento</a></li>
                        </ul>
                    </li>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Dashboards
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="dashboard_atividades.php">Dashboard Atividades</a></li>
                            <li><a class="dropdown-item" href="novo_agendamento.php">Dashboard Agendamentos</a></li>
                        </ul>
                    </li>
                        <!--SweetAlert-->
                        <!--Repositorio professora --  https://github.com/vanessaborges2/Eletiva-1-2025-->
            </div>
            <div class="d-flex">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= $_SESSION['usuario'] ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="alterar_dados.php">Alterar Dados</a></li>
                            <li><a class="dropdown-item btn btn-danger" id="btnSair"  href="sair.php" id="logoutButton">Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center ms-auto">
      <!-- Imagem do usuário -->
      <img src="eu.jpg" alt="Usuário" width="32" height="32" class="rounded-circle me-2">
    </div>
        </div>
    </nav>
    <main class="container">