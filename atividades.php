<?php
require_once('cabecalho.php');

function exibirAtividades()
{
    try {
        require("conexao.php");
        $sql = "  SELECT 
        atividades.idAtividade,
        atividades.descricao,
        atividades.inicio,
        atividades.fim,
        projetos.nome AS nome_projeto
    FROM atividades
    INNER JOIN projetos ON atividades.idProjeto = projetos.id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        echo "Erro ao Consultar Banco" . $th->getMessage();
    }
}

$atividades = exibirAtividades();
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_GET['id'])) {
        $mensagem = alterarProjeto($_GET['id'], $_POST['nome'], $_POST['descricao'], $_POST['inicio'], $_POST['fim']);
    } else {
        echo "<p class='text-danger'>ID não informado para alteração.</p>";
    }
}

?>

<h2>Atividades</h2>
<div class="d-flex justify-content-between mb-3">
    <a href="nova_atividade.php" class="btn btn-success mb-3">Novo Registro</a>
    <div class="ms-auto">
        <a href="pesquisar_projeto.php" class="btn btn-primary">Pesquisar</a>
    </div>
</div>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>DESCRIÇÃO</th>
            <th>PROJETO</th>
            <th>INÍCIO</th>
            <th>FIM</th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($atividades as $c): // per
        ?>
            <tr>
                <td><?= $c['idAtividade'] ?></td>
                <td><?= $c['descricao'] ?></td>
                <td><?= $c['nome_projeto'] ?></td>
                <td><?= $data_formatada = (new DateTime($c['inicio']))->format('d/m/Y') ?></td>
                <td><?= $data_formatada = (new DateTime($c['fim']))->format('d/m/Y') ?></td>
                <td>
                    <a href="alterar_atividade.php?id=<?= $c['idAtividade'] ?>" class="btn btn-warning">Editar</a>
                    <a href="deletar_atividade.php?id=<?= $c['idAtividade']?>" class="btn btn-danger">Deletar</a>
                </td>
            </tr>
        <?php
        endforeach;
        ?>
    </tbody>
</table>



<?php require_once('rodape.php'); ?>