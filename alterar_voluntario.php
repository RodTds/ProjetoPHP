<?php
require_once('cabecalho.php');

function retornaDadosVoluntario()
{
    require("conexao.php");

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM voluntarios WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        die("ID não informado");
    }
}

function alterarDadosVoluntario($id, $nome, $email, $telefone)
{
    require("conexao.php");
    try {

        $sql = "UPDATE voluntarios SET nome = ?, email = ?,telefone = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$nome, $email, $telefone, $id]))
            return true;
        else
            return false;
    } catch (Exception $e) {
        die("Erro ao alterar dados do Voluntário" . $e->getMessage());
    }
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_GET['id'])) {
        $mensagem = alterarDadosVoluntario($_GET['id'], $_POST['nome'], $_POST['email'], $_POST['telefone']);
    } else {
        echo "<p class='text-danger'>ID não informado para alteração.</p>";
    }
}
$voluntario = retornaDadosVoluntario();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 bg-white rounded-4 shadow p-5">

            <h3 class="mb-4 text-center">Alteração de Dados Pessoais</h3>
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
                    <label for="nome" class="form-label">Nome do Voluntário</label>
                    <input value="<?= $voluntario['nome'] ?>" type="text" id="nome" name="nome" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input value="<?= $voluntario['email'] ?>" type="text" id="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input value="<?= $voluntario['telefone'] ?>" type="text" id="telefone" name="telefone" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="voluntarios.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>

            <hr class="my-4">

            <h3 class="mb-4 text-center">Alteração da Senha</h3>
            <form method="post">
                <div class="mb-3">
                    <label for="senha_antiga" class="form-label">Informe a senha antiga</label>
                    <input type="password" id="senha_antiga" name="senha_antiga" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="nova_senha" class="form-label">Informe a nova senha</label>
                    <input type="password" id="nova_senha" name="nova_senha" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="nova_senha_confirm" class="form-label">Repita a nova senha</label>
                    <input type="password" id="nova_senha_confirm" name="nova_senha_confirm" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="voluntarios.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>


<?php require_once('rodape.php'); ?>