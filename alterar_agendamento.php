<?php
require_once("cabecalho.php");

function retornarDados($id)
{
    require('conexao.php');
    try {
        $sql = "SELECT
                    v.id AS idVoluntario,
                    v.nome AS nome,
                    a.idAtividade AS idAtividade,
                    a.descricao AS descricao,
                    ag.dataAgendamento,
                    ag.hora_inicio,
                    ag.hora_fim,
                    ag.observacoes
                FROM agenda ag
                INNER JOIN voluntarios v ON ag.idVoluntario = v.id
                INNER JOIN atividades a ON ag.idAtividade = a.idAtividade
                WHERE ag.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $agendamento = $stmt->fetch();
        if (!$agendamento) {
            die("Erro ao consultar registro");
        }
        return $agendamento;
    } catch (PDOException $e) {
        die("Erro ao consultar Agenda: " . $e->getMessage());
    }
}

function retornarVoluntarios()
{
    require('conexao.php');
    try {
        $sql = "SELECT id, nome FROM voluntarios";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao consultar voluntários: " . $e->getMessage());
    }
}

function retornarAtividades()
{
    require('conexao.php');
    try {
        $sql = "SELECT idAtividade, descricao FROM atividades";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao consultar atividades: " . $e->getMessage());
    }
}

function alterarAgendamento($idvoluntario, $idatividade, $data, $hora_inicio, $hora_fim, $observacoes, $id)
{
    try {
        require("conexao.php");
        $stmt = $pdo->prepare("UPDATE agenda SET 
                idVoluntario = ?, 
                idAtividade = ?, 
                dataAgendamento = ?, 
                hora_inicio = ?, 
                hora_fim = ?, 
                observacoes = ?
                WHERE id = ?");
        if ($stmt->execute([$idvoluntario, $idatividade, $data, $hora_inicio, $hora_fim, $observacoes, $id])) {
            header("location: agenda.php?edicao=true");
            
        } else {
            header("location: agenda.php?edicao=false");
            
        }
    } catch (Exception $e) {
        die("Erro ao alterar agendamento: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $idvoluntario = $_POST['voluntario'];
    $idatividade = $_POST['atividade'];
    $data = $_POST['data'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fim = $_POST['hora_fim'];
    $observacoes = $_POST['observacoes'];

    alterarAgendamento($idvoluntario, $idatividade, $data, $hora_inicio, $hora_fim, $observacoes, $id);
} else {
    $agendamento = retornarDados($_GET['id']);
    $voluntarios = retornarVoluntarios();
    $atividades = retornarAtividades();
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 bg-white rounded-4 shadow p-5">

            <h3 class="mb-4 text-center">Alterar Agendamento</h3>

            <form method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">

                <div class="mb-3">
                    <label for="voluntario" class="form-label">Voluntário</label>
                    <select class="form-control" id="voluntario" name="voluntario" required>
                        <option value="">Selecione o voluntário</option>
                        <?php foreach ($voluntarios as $vol): ?>
                            <option value="<?= $vol['id'] ?>" <?= ($vol['id'] == $agendamento['idVoluntario']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($vol['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="atividade" class="form-label">Atividade</label>
                    <select class="form-control" id="atividade" name="atividade" required>
                        <option value="">Selecione a atividade</option>
                        <?php foreach ($atividades as $atv): ?>
                            <option value="<?= $atv['idAtividade'] ?>" <?= ($atv['idAtividade'] == $agendamento['idAtividade']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($atv['descricao']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="data" class="form-label">Data</label>
                    <input value="<?= $agendamento['dataAgendamento'] ?>" type="date" id="data" name="data" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="hora_inicio" class="form-label">Hora de Início</label>
                    <input value="<?= $agendamento['hora_inicio'] ?>" type="time" id="hora_inicio" name="hora_inicio" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="hora_fim" class="form-label">Hora de Fim</label>
                    <input value="<?= $agendamento['hora_fim'] ?>" type="time" id="hora_fim" name="hora_fim" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="observacoes" class="form-label">Observações</label>
                    <input value="<?= htmlspecialchars($agendamento['observacoes']) ?>" type="text" id="observacoes" name="observacoes" class="form-control" required>
                </div>

                <div class="form-group d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary" style="width: 48%;">Salvar</button>
                    <a href="agenda.php" class="btn btn-danger" style="width: 48%;">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</div>

<?php require_once("rodape.php"); ?>
