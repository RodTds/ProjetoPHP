<?php
  require_once("cabecalho.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulários de Cadastro</title>
    <!-- Link para o CSS do Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Adicionando o estilo para o fundo branco e leve relevo */
        body {
            background-color: #f8f9fa;
         
        }

        .form-container {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<?php
    require('conexao.php');
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        try {
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $inicio =$_POST['inicio'];
            $fim =$_POST['fim'];
            $stmt = $pdo->prepare("INSERT INTO projetos(nome,descricao,inicio,fim) VALUES(?,?,?,?)");
            if($stmt->execute([$nome,$descricao,$inicio,$fim]))
               echo"Projeto Cadastrado Com Sucesso !";
            else
               echo "!! ATEÇÃO !! Cadastro Não Realizado !!";
        } catch (\Throwable $th) {
            echo"Erro ao Cadastrar Projeto". $th->getMessage();
        }
    }
?>
<body class="">

    <div class="container">
        
        <!-- Formulário de Cadastro de Projeto -->
        <div class="row justify-content-center">
            <div class="col-md-6 form-container">
                <h2 class="text-center">Cadastro de Projeto</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome do Projeto</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" required>
                    </div>
                    <div class="form-group">
                        <label for="inicio">Data de Início</label>
                        <input type="date" class="form-control" id="inicio" name="inicio" required>
                    </div>
                    <div class="form-group">
                        <label for="fim">Data de Fim</label>
                        <input type="date" class="form-control" id="fim" name="fim" required>
                    </div>
                    <button type="submit" class="btn btn-custom btn-block">Salvar Projeto</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts do Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
  require_once("rodape.php");
?>