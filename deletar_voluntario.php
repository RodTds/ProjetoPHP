<?php
require("cabecalho.php");

function retornarVoluntario($id)
{
    require("conexao.php");
    try {
        $sql = "SELECT * FROM voluntarios WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $th) {
        die("Erro ao consultar voluntário: " . $th->getMessage());
    }
}

function excluirVoluntario($id)
{
    require("conexao.php");
    try {
        $sql = "DELETE FROM voluntarios WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id])) {
            header("location: voluntarios.php?exclusao=true");
        } else {
            header("location: voluntarios.php?exclusao=false");
        }
    } catch (PDOException $th) {
        if ($th->getCode() === '23000') {
            die('<div class="alert alert-danger p-3 rounded">
                    <strong>Erro:</strong> Não é possível excluir o voluntario porque ela está relacionada a outro registro.
                    <br><a class="btn btn-primary mt-3" href="voluntarios.php">Voltar</a>
                </div>');
        } else {
            die('<div class="alert alert-danger">Erro ao Excluir Atividade: ' . $th->getMessage() . '</div>');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    excluirVoluntario($id);
} else {
    $voluntario = retornarVoluntario($_GET['id']);
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 bg-white shadow p-4 rounded mt-5">
            <h2 class="text-center mb-4">Deletar Voluntário</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="number" class="form-control rounded" id="id" name="id" value="<?= $voluntario['id'] ?? '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control rounded" id="nome" name="nome" value="<?= $voluntario['nome'] ?? '' ?>" placeholder="Opcional (não usado para deletar)">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control rounded" id="email" name="email" value="<?= $voluntario['email'] ?? '' ?>" placeholder="Opcional (não usado para deletar)">
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" class="form-control rounded" id="telefone" name="telefone" value="<?= $voluntario['telefone'] ?? '' ?>" placeholder="Opcional (não usado para deletar)">
                </div>
                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-primary btn-block">Deletar</button>
                    <a href="voluntarios.php" class="btn btn-danger btn-block">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once("rodape.php");
?>
