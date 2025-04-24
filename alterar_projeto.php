
<?php
require_once('cabecalho.php');

function retornarProjeto()
{
    require("conexao.php");

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM projetos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        die("ID não informado");
    }
}

function alterarProjeto($id, $nome, $descricao, $inicio,$fim)
{
    require("conexao.php");
    try {

        $sql = "UPDATE projetos SET nome = ?, descricao = ?,inicio = ?, fim = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$nome,$descricao, $inicio,$fim, $id]))
            return true;
        else
            return false;
    } catch (Exception $e) {
        die("Erro ao alterar dados do Voluntário" . $e->getMessage());
    }
}

$projeto = retornarProjeto();
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_GET['id'])) {
        $mensagem = alterarProjeto($_GET['id'], $_POST['nome'], $_POST['descricao'], $_POST['inicio'],$_POST['fim']);
    } else {
        echo "<p class='text-danger'>ID não informado para alteração.</p>";
    }
}

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 bg-white rounded-4 shadow p-5">

            <h3 class="mb-4 text-center">Alteração de Dados do Projeto</h3>
            <?php if ($mensagem): ?>
                <div class="alert alert-danger mt-3 mb-3">
                    Dados Alterados com Sucesso !
                </div>
            <?php else: ?>
                <div class="alert alert-warning mt-3 mb-3">
                    Nenhuma alteração foi realizada.
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Projeto</label>
                    <input value="<?= $projeto['nome'] ?>" type="text" id="nome" name="nome" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descricao</label>
                    <input value="<?= $projeto['descricao'] ?>" type="text" id="descricao" name="descricao" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="inicio" class="form-label">Inicio</label>
                    <input value="<?= $projeto['inicio'] ?>" type="date" id="inicio" name="inicio" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="fim" class="form-label">Fim</label>
                    <input value="<?= $projeto['fim'] ?>" type="date" id="fim" name="fim" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="projetos.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>

            <hr class="my-4">

          
        </div>
    </div>
</div>


<?php require_once('rodape.php'); ?>