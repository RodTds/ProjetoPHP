<?php
require_once("cabecalho.php");
require('conexao.php');

// busca os projetos no banco SEMPRE (não só no POST)
$stmtProjetos = $pdo->query("SELECT id, nome FROM projetos ORDER BY descricao DESC");
$projetos = $stmtProjetos->fetchAll(PDO::FETCH_ASSOC);

// se for POST, realiza o cadastro da atividade
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $descricao = $_POST['descricao'];
        $idprojeto = $_POST['idprojeto'];
        $inicio = $_POST['inicio'];
        $fim = $_POST['fim'];

        // inserção no banco
        $stmt = $pdo->prepare("INSERT INTO atividades (descricao, idProjeto, inicio, fim) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$descricao, $idprojeto, $inicio, $fim])) {
            echo "<div class='alert alert-success text-center'>Atividade cadastrada com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Erro ao cadastrar atividade.</div>";
        }
    } catch (\Throwable $th) {
        echo "<div class='alert alert-danger text-center'>Erro: " . $th->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 form-container">
            <h2 class="text-center">Cadastro de Atividade</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="descricao">Descrição da Atividade</label>
                    <input type="text" class="form-control" id="descricao" name="descricao" required>
                </div>

                <div class="form-group">
                    <label for="idprojeto">Projeto Relacionado</label>
                    <select class="form-control" id="idprojeto" name="idprojeto" required>
                        <option value="">Selecione um Projeto</option>
                        <?php foreach ($projetos as $projeto): ?>
                            <option value="<?= $projeto['id'] ?>">
                                <?= htmlspecialchars($projeto['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inicio">Data de Início</label>
                    <input type="date" class="form-control" id="inicio" name="inicio" required>
                </div>

                <div class="form-group">
                    <label for="fim">Data de Fim</label>
                    <input type="date" class="form-control" id="fim" name="fim" required>
                </div>

                <button type="submit" class="btn btn-custom btn-block">Salvar Atividade</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php require_once("rodape.php"); ?>
