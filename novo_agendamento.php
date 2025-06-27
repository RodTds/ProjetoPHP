<?php
require_once("cabecalho.php");
require('conexao.php');

// busca os voluntários no banco para exibir no foreach
$stmtVoluntarios = $pdo->query("SELECT id, nome FROM voluntarios ORDER BY nome");
$voluntarios = $stmtVoluntarios->fetchAll(PDO::FETCH_ASSOC);

// busca as atividades no banco para exibir no foreach
$stmtAtividades = $pdo->query("SELECT idAtividade, descricao FROM atividades ORDER BY descricao");
$atividades = $stmtAtividades->fetchAll(PDO::FETCH_ASSOC);

$mensagem = null;
$alertType = '';

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
        $stmt = $pdo->prepare("INSERT INTO agenda (idVoluntario, idAtividade, dataAgendamento, hora_inicio, hora_fim, observacoes) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$idvoluntario, $idatividade, $data, $hora_inicio, $hora_fim, $observacoes])) {
            $mensagem = "Atividade cadastrada com sucesso!";
            $alertType = "success";
        } else {
            $mensagem = "Erro ao cadastrar atividade.";
            $alertType = "danger";
        }
    } catch (\Throwable $th) {
        $mensagem = "Erro: " . $th->getMessage();
        $alertType = "danger";
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 bg-white shadow p-4 rounded mt-5">
            <h2 class="text-center mb-4">Agendamento</h2>

            <?php if ($mensagem): ?>
                <div class="alert alert-<?= $alertType ?> text-center"><?= htmlspecialchars($mensagem) ?></div>
            <?php endif; ?>

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
                    <label for="idatividade">Atividade</label>
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
                    <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                </div>

                <div class="form-group">
                    <label for="hora_fim">Hora de Fim</label>
                    <input type="time" class="form-control" id="hora_fim" name="hora_fim" required>
                </div>

                <div class="form-group">
                    <label for="observacoes">Observações</label>
                    <input type="text" class="form-control" id="observacoes" name="observacoes" required>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-block">Salvar na Agenda</button>
                    <a href="agenda.php" class="btn btn-danger btn-block">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once("rodape.php"); ?>
