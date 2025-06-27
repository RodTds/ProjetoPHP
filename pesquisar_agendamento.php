<><?php
require_once("cabecalho.php");
?>

<?php
function pesquuisarAtividade()
{
    require("conexao.php");
    try {
        if (isset($_POST['pesquisado']) && trim($_POST['pesquisado']) !== '') {
            $pesquisado = $_POST['pesquisado'];
            $stmt = $pdo->prepare("SELECT a.idAtividade,a.descricao,p.nome AS projeto,a.inicio,a.fim FROM atividades a
      INNER JOIN projetos p ON a.idProjeto = p.id
       WHERE a.descricao LIKE ?");
            $stmt->execute(["%$pesquisado%"]); // busca parcial com LIKE
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    } catch (Exception $th) {
        die("Erro ao consultar nome no banco: " . $th->getMessage());
    }
}
$pesquisados = pesquisarAtividade();
?>

<h2>Projetos</h2>
<!-- Formulário de pesquisa alinhado à direita -->
<div class="d-flex justify-content-end mb-3">
    <form class="d-flex" method="post" action="">
        <input type="text" name="pesquisado" id="pesquisado" class="form-control me-2"
            placeholder="Digite o nome da Atividade"
            value="<?= isset($_POST['pesquisado']) ? htmlspecialchars($_POST['pesquisado']) : '' ?>">
        <button type="submit" class="btn btn-primary">Pesquisar</button>
    </form>
</div>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Voluntario</th>
            <th>Atividade</th>
            <th>Data</th>
            <th>Inicio</th>
            <th>Fim</th>
        </tr>
    </thead>
    <tbody>
        <?php

        foreach ($pesquisados as $c):
            // no campo data, INICIO E FIM doi adicionado a clase
            // Datetime para formatar a data no padrao Brasileiro
            ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= $c['voluntario'] ?></td>
                 <td><?= $c['atividade'] ?></td>
                <td><?= $c['data'] ?></td>
                <td><?= $data_formatada = (new DateTime($c['inicio']))->format('d/m/Y') ?></td>
                <td><?= $data_formatada = (new DateTime($c['fim']))->format('d/m/Y') ?></td>
                <td>
                    <a href="alterar_atividade.php?id=<?= $c['idAtividade'] ?>" class="btn btn-warning">Editar</a>
                    <a href="deletar_atividade.php?id=<?= $c['idAtividade'] ?>" class="btn btn-danger">Deletar</a>
                </td>
            </tr>
            <?php

        endforeach;
        ?>
    </tbody>
</table>
<?php
require_once("rodape.php");
?>