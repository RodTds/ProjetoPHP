<?php
require("cabecalho.php");

function consultarAtividade()
{
    require("conexao.php");

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        $sql = "SELECT * FROM atividades WHERE idAtividade = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        die("ID não informado");
    }
}

function excluirAtividade($id)
{
    require_once("conexao.php");
    try {
       global $pdo;
        $sql = "DELETE FROM atividades WHERE id= ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id])) {
            header('location: atividades.php?exclusao=true');
        } else {
            header('location: atividades.php?exclusao=false');
        }
    } catch (Exception $th) {
        die("Erro ao Excluir Atividade !" . $th->getMessage());
    }
}
$resultados = consultarAtividade();

?>

<style>
    .centered-wrapper {
        background-color: #f0f2f5;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        flex-direction: column;
    }

    .form-container {
        background-color: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
    }

    h2 {
        text-align: center; /* Centralizando o título */
    }
</style>

<div class="centered-wrapper">
    <h2>Excluir Atividades</h2> <!-- Título centralizado -->
    <form method="post" class="form-container">
        <div class="mb-3">
            <label for="idAtividade" class="form-label">ID</label>
            <input value="<?= $resultados['idAtividade'] ?>" type="text" id="idAtividade" name="idAtividade" class="form-control">
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">DESCRIÇÃO</label>
            <input value="<?= $resultados['descricao'] ?>" type="text" id="descricao" name="descricao" class="form-control">
        </div>

        <div class="mb-3">
            <label for="idprojeto" class="form-label">PROJETO</label>
            <input value="<?= $resultados['idProjeto'] ?>" type="text" id="idprojeto" name="idprojeto" class="form-control">
        </div>

        <div class="mb-3">
            <label for="inicio" class="form-label">INÍCIO</label>
            <input value="<?= (new DateTime($resultados['inicio']))->format('d/m/y') ?>" type="text" id="inicio" name="inicio" class="form-control">
        </div>

        <div class="mb-3">
            <label for="fim" class="form-label">FIM</label>
            <input value="<?= (new DateTime($resultados['fim']))->format('d/m/y') ?>" type="text" id="fim" name="fim" class="form-control">
        </div>
        <button type="submit" class="btn btn-danger w-100">Deletar</button>
    </form>
</div>

<?php
require("rodape.php");
?>
