<?php
require_once("cabecalho.php");

function consultarAtividade($id) {
    require("conexao.php");
    try {
        $sql = "SELECT a.idAtividade, a.descricao, p.nome AS nome, a.inicio, a.fim
                FROM atividades a
                INNER JOIN projetos p ON a.idProjeto = p.id
                WHERE a.idAtividade = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao consultar atividade: " . $e->getMessage());
    }
}

function alterarAtividade($id, $descricao, $inicio, $fim) {
    require("conexao.php");
    try {
        $sql = "UPDATE atividades SET descricao = ?, inicio = ?, fim = ? WHERE idAtividade = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$descricao, $inicio, $fim, $id]);
    } catch (Exception $e) {
        die("Erro ao alterar atividade: " . $e->getMessage());
    }
}

// Processamento
$mensagem = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $descricao = $_POST["descricao"];
    $inicio = $_POST["inicio"];
    $fim = $_POST["fim"];

    if (alterarAtividade($id, $descricao, $inicio, $fim)) {
        $mensagem = "Atividade alterada com sucesso!";
    } else {
        $mensagem = "Nenhuma alteração realizada.";
    }

    $atividade = consultarAtividade($id); // atualiza dados
} else {
    $atividade = consultarAtividade($_GET['id']);
}
?>

<!-- Estilo -->
<style>
    .card-container {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-top: 40px;
    }

    .title-box {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        margin-bottom: 25px;
        text-align: center;
    }

    .btn-spacing {
        margin-top: 15px;
    }
</style>

<!-- Conteúdo -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 card-container">

            <div class="title-box">
                <h2>Alterar Atividade</h2>
            </div>

            <?php if ($mensagem): ?>
                <div class="alert alert-info"><?= $mensagem ?></div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="id" value="<?= $atividade['idAtividade'] ?>">

                <div class="form-group">
                    <label for="descricao">Descrição da Atividade</label>
                    <input value="<?= $atividade['descricao'] ?>" type="text" class="form-control" id="descricao" name="descricao" required>
                </div>

                <div class="form-group">
                    <label for="inicio">Data de Início</label>
                    <input value="<?= $atividade['inicio'] ?>" type="date" class="form-control" id="inicio" name="inicio" required>
                </div>

                <div class="form-group">
                    <label for="fim">Data de Fim</label>
                    <input value="<?= $atividade['fim'] ?>" type="date" class="form-control" id="fim" name="fim" required>
                </div>

                <div class="form-group">
                    <label for="idprojeto">Projeto</label>
                    <input value="<?= $atividade['nome'] ?>" type="text" class="form-control" id="idprojeto" name="idprojeto" readonly>
                </div>

                <div class="d-flex flex-column">
                    <button type="submit" class="btn btn-success btn-block">Salvar Alterações</button>
                    <a href="atividades.php" class="btn btn-secondary btn-block btn-spacing">Cancelar</a>
                    <a href="projetos.php" class="btn btn-primary btn-block btn-spacing">Ver Projetos</a>
                </div>
            </form>

        </div>
    </div>
</div>

<?php require_once("rodape.php"); ?>
