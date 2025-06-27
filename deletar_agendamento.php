<?php
require("cabecalho.php");

function consultarAgenda($id)
{
    require("conexao.php");
    try {
        $sql = "SELECT ag.id as id, 
                v.nome as nome,
                ati.descricao as descricao,
                ag.dataAgendamento as dataAgendamento,
                ag.hora_inicio as hora_inicio,
                ag.hora_fim as hora_fim,
                ag.observacoes as observacoes
            FROM agenda ag 
            INNER JOIN voluntarios v ON ag.idVoluntario = v.id
            INNER JOIN atividades ati ON ag.idAtividade = ati.idAtividade
            WHERE ag.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch (Exception $th) {
        die("Erro ao Consultar banco: " . $th->getMessage());
    }
}

function excluirAgendamento($id)
{
    require("conexao.php");
    try {
        $sql = "DELETE FROM agenda WHERE id= ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id])) {
            header("location: agenda.php?mensagem=true");
        } else {
            header("location: agenda.php?mensagem=false");
        }
        exit;
    } catch (Exception $th) {
        die("Erro ao excluir registro do banco: " . $th->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    excluirAgendamento($id);
} else {
    $resultado = consultarAgenda($_GET['id']);
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 form-container bg-white p-4 rounded shadow">
            <h2 class="text-center mb-4">Excluir Agendamento</h2>
            <form method="post">
                <div class="form-group mb-3">
                    <label for="id">ID</label>
                    <input type="number" class="form-control" id="id" name="id" value="<?= htmlspecialchars($resultado['id']) ?>" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="voluntario">Voluntário</label>
                    <input type="text" class="form-control" id="voluntario" name="voluntario" value="<?= htmlspecialchars($resultado['nome']) ?>" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="atividade">Atividade</label>
                    <input type="text" class="form-control" id="atividade" name="atividade" value="<?= htmlspecialchars($resultado['descricao']) ?>" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="data">Data</label>
                    <input type="date" class="form-control" id="data" name="data" value="<?= $resultado['dataAgendamento'] ?>" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="inicio">Início</label>
                    <input type="text" class="form-control" id="inicio" name="inicio" value="<?= htmlspecialchars($resultado['hora_inicio']) ?>" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="fim">Fim</label>
                    <input type="text" class="form-control" id="fim" name="fim" value="<?= htmlspecialchars($resultado['hora_fim']) ?>" readonly>
                </div>

                <div class="form-group mb-4">
                    <label for="observacoes">Observações</label>
                    <input type="text" class="form-control" id="observacoes" name="observacoes" value="<?= htmlspecialchars($resultado['observacoes']) ?>" readonly>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger">Deletar</button>
                    <a href="agenda.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require("rodape.php");
?>
