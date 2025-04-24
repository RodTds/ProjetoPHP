<?php
require_once("cabecalho.php");
require('conexao.php');

// busca os volunntarios no banco para exibir no foreach
$stmtVoluntarios = $pdo->query("SELECT id, nome FROM voluntarios ORDER BY nome ");
$voluntarios = $stmtVoluntarios->fetchAll(PDO::FETCH_ASSOC);
// busca as atividades no banco para exibir no foreach
$stmtAtividades = $pdo->query("SELECT idAtividade, descricao FROM atividades ORDER BY descricao");
$atividades = $stmtAtividades->fetchAll(PDO::FETCH_ASSOC);

// se for POST, realiza o cadastro da atividade
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
      
        $idvoluntario = $_POST['idvoluntario'];
        $idatividade = $_POST['idatividade'];
        $data = $_POST['data'];
        $hora_inicio = $_POST['hora_inicio'];
        $hora_fim = $_POST['hora_fim'];
        $observacoes = $_POST['observacoes'];


        // inserção no banco
        $stmt = $pdo->prepare("INSERT INTO 
        agenda (idVoluntario, idAtividade, dataAgendamento,hora_inicio, hora_fim,observacoes)
         VALUES (?, ?, ?,?,?, ?)");
        if ($stmt->execute([$idvoluntario, $idatividade,$data, $hora_inicio, $hora_fim,$observacoes])) {
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
    <title>Agenda</title>
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

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 form-container">
            <h2 class="text-center">Agendamento</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="idvoluntario">Voluntário</label>
                    <select class="form-control" id="idvoluntario" name="idvoluntario" required>
                        <option value="">Selecione um voluntário</option>
                        <?php foreach ($voluntarios as $voluntario): ?>
                            <option value="<?= $voluntario['id'] ?>">
                                <?= htmlspecialchars($voluntario['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="idatividade"> Atividade</label>
                    <select class="form-control" id="idatividade" name="idatividade" required>
                        <option value="">Selecione uma atividade</option>
                        <?php foreach ($atividades as $atividade): ?>
                            <option value="<?= $atividade['idAtividade'] ?>">
                                <?= htmlspecialchars($atividade['descricao']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="data">Data</label>
                    <input type="date" class="form-control" id="data" name="data" required>
                </div>
                <div class="form-group">
                    <label for="hora_inicio">Hora de Início</label>
                    <input type="time" class="form-control" id="inicio" name="hora_inicio" required>
                </div>

                <div class="form-group">
                    <label for="hora_fim">Hora de Fim</label>
                    <input type="time" class="form-control" id="hora_fim" name="hora_fim" required>
                </div>
                <div class="form-group">
                    <label for="observacoes">Observações</label>
                    <input type="tex" class="form-control" id="observacoes" name="observacoes" required>
                </div>

                <button type="submit" class="btn btn-custom btn-block">Salvar Atividade</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<?php require_once("rodape.php"); ?>
