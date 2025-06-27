<?php
require_once("cabecalho.php");
require("conexao.php");

function retornarProjeto($id)
{
    try {
        global $pdo;
        $sql = "SELECT * FROM projetos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        if ($th->getCode() === '23000') {
            die('<div class="alert alert-danger p-3 rounded">
                    <strong>Erro:</strong> Não é possível excluir o projeto porque ela está relacionada a outro registro.
                    <br><a class="btn btn-primary mt-3" href="projetos.php">Voltar</a>
                </div>');
        } else {
            die('<div class="alert alert-danger">Erro ao Excluir Atividade: ' . $th->getMessage() . '</div>');
        }
    }
}

function excluirProjeto($id)
{
    try {
        global $pdo;
        $sql = "DELETE FROM projetos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id])) {
            header("Location: agenda.php?exclusao=true");
            exit;
        } else {
            header("Location: agenda.php?exclusao=false");
            exit;
        }
    } catch (Exception $e) {
        die("Erro ao excluir projeto: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    excluirProjeto($id);
} else {
    if (isset($_GET['id'])) {
        $projeto = retornarProjeto($_GET['id']);
    } else {
        // Se não tiver ID no GET, redireciona
        header("Location: agenda.php");
        exit;
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 bg-white shadow p-4 rounded mt-5">
            <h2 class="text-center mb-4">Deletar Projeto</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="number" class="form-control rounded" id="id" name="id" value="<?= htmlspecialchars($projeto['id'] ?? '') ?>" required readonly>
                </div>
                <div class="form-group">
                    <label for="nome">Nome do Projeto</label>
                    <input type="text" class="form-control rounded" id="nome" name="nome" value="<?= htmlspecialchars($projeto['nome'] ?? '') ?>" placeholder="Opcional (não usado para deletar)" readonly>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control rounded" id="descricao" name="descricao" value="<?= htmlspecialchars($projeto['descricao'] ?? '') ?>" placeholder="Opcional (não usado para deletar)" readonly>
                </div>
                <div class="form-group">
                    <label for="inicio">Data de Início</label>
                    <input type="date" class="form-control rounded" id="inicio" name="inicio" value="<?= htmlspecialchars($projeto['inicio'] ?? '') ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="fim">Data de Fim</label>
                    <input type="date" class="form-control rounded" id="fim" name="fim" value="<?= htmlspecialchars($projeto['fim'] ?? '') ?>" readonly>
                </div>
                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-danger btn-block">Deletar</button>
                    <a href="projetos.php" class="btn btn-secondary btn-block">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once("rodape.php");
?>
