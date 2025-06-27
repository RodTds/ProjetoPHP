<?php
ob_start();
require("cabecalho.php");

function consultarAtividade($id)
{
    require("conexao.php");
    try {
        $sql = "SELECT a.idAtividade,a.descricao,p.nome AS nome,a.inicio,a.fim
         FROM atividades a
         INNER JOIN projetos p ON a.idProjeto = p.id
         WHERE a.idAtividade = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erro ao consultar Banco Tabela atividades: " . $e->getMessage() . "</div>";
    }
}

function excluirAtividade($id)
{
    require_once("conexao.php");
    try {
        $sql = "DELETE FROM atividades WHERE idAtividade = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id])) {
            header('location: atividades.php');
            exit;
        } else {
            header('location: atividades.php');
            exit;
        }
    } catch (PDOException $th) {
        if ($th->getCode() === '23000') {
            die('<div class="alert alert-danger p-3 rounded">
                    <strong>Erro:</strong> Não é possível excluir a atividade porque ela está relacionada a outro registro.
                    <br><a class="btn btn-primary mt-3" href="atividades.php">Voltar</a>
                </div>');
        } else {
            die('<div class="alert alert-danger">Erro ao Excluir Atividade: ' . $th->getMessage() . '</div>');
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    excluirAtividade($id);
} else {
    $resultados = consultarAtividade($_GET['id']);
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 form-container bg-white p-4 rounded shadow">
            <h2 class="text-center mb-4">Excluir Atividade</h2>
            <form method="post">
                <div class="form-group mb-3">
                    <label for="id">ID</label>
                    <input type="text" class="form-control" id="id" name="id"
                        value="<?= htmlspecialchars($resultados['idAtividade']) ?>" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control" id="descricao" name="descricao"
                        value="<?= htmlspecialchars($resultados['descricao']) ?>" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="idprojeto">Projeto</label>
                    <input type="text" class="form-control" id="idprojeto" name="idprojeto"
                        value="<?= htmlspecialchars($resultados['nome']) ?>" readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="inicio">Início</label>
                    <input type="text" class="form-control" id="inicio" name="inicio"
                        value="<?= (new DateTime($resultados['inicio']))->format('d/m/Y') ?>" readonly>
                </div>

                <div class="form-group mb-4">
                    <label for="fim">Fim</label>
                    <input type="text" class="form-control" id="fim" name="fim"
                        value="<?= (new DateTime($resultados['fim']))->format('d/m/Y') ?>" readonly>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger">Deletar</button>
                    <a href="atividades.php" class="btn btn-secondary">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php
ob_end_flush();
require("rodape.php");
?>