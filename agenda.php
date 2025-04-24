<?php
require_once('cabecalho.php');

function exibirAgendamentos()
{
    try {
        require("conexao.php");
        $sql = "SELECT 
        agenda.id,
        voluntarios.nome AS nomeVoluntario,
        atividades.descricao AS descricaoAtividade,
        agenda.dataAgendamento,
        agenda.hora_inicio,
        agenda.hora_fim,
        agenda.observacoes
    FROM agenda
    INNER JOIN voluntarios ON voluntarios.id = agenda.idVoluntario
    INNER JOIN atividades ON atividades.idAtividade = agenda.idAtividade";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        echo "Erro ao Consultar Banco" . $th->getMessage();
    }
}

function alterarProjeto($id, $nome, $descricao, $inicio, $fim)
{
    require("conexao.php");
    try {

        $sql = "UPDATE projetos SET nome = ?, descricao = ?,hora_inicio = ?, hora_fim = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$nome, $descricao, $inicio, $fim, $id]))
            return true;
        else
            return false;
    } catch (Exception $e) {
        die("Erro ao alterar dados do Voluntário" . $e->getMessage());
    }
}

$agendamentos = exibirAgendamentos();
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_GET['id'])) {
        $mensagem = alterarProjeto($_GET['id'], $_POST['nome'], $_POST['descricao'], $_POST['inicio'], $_POST['fim']);
    } else {
        echo "<p class='text-danger'>ID não informado para alteração.</p>";
    }
}

?>

<h2>Agendamentos</h2>
<div class="d-flex justify-content-between mb-3">
    <a href="novO_aGENDAMENTO.php" class="btn btn-success mb-3">Novo Agendamento</a>
    <div class="ms-auto">
        <a href="pesquisar_agendamento.php" class="btn btn-primary">Pesquisar</a>
    </div>
</div>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>VOLUNTÁRIO</th>
            <th>ATIVIDADE</th>
            <th>DATA</th>
            <th>INÍCIO</th>
            <th>FIM</th>
            <th>OBSERVAÇÕES</th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($agendamentos as $agendamento): // per
        ?>
            <tr>
            <td><?= $agendamento['id'] ?></td>
                <td><?= $agendamento['nomeVoluntario'] ?></td>
                <td><?= $agendamento['descricaoAtividade'] ?></td>
                <td><?= $data_formatada = (new DateTime($agendamento['dataAgendamento']))->format('d/m/Y') ?></td>
                <td><?= (new DateTime($agendamento['hora_inicio']))->format('H:i') ?></td>
                <td><?= (new DateTime($agendamento['hora_fim']))->format('H:i') ?></td>
                 <td><?= $agendamento['observacoes']?></td>
                <td>
                    <a href="alterar_agendamento.php?id=<?= $agendamento['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="" class="btn btn-danger">Deletar</a>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>



<?php require_once('rodape.php'); ?>