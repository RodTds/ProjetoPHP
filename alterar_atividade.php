<?php
require_once("cabecalho.php");

function consultarAtividade($id)
{
    require("conexao.php");
    try {
        $sql = "SELECT a.idAtividade, a.descricao, p.id AS idProjeto, p.nome AS nomeProjeto, a.inicio, a.fim
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

function alterarAtividade($id, $descricao, $inicio, $fim, $idProjeto)
{
    require("conexao.php");
    try {
        $sql = "UPDATE atividades SET descricao = ?, inicio = ?, fim = ?, idProjeto = ? WHERE idAtividade = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$descricao, $inicio, $fim, $idProjeto, $id]);
    } catch (Exception $e) {
        die("Erro ao alterar atividade: " . $e->getMessage());
    }
}

function retornarProjetos()
{
    require("conexao.php");
    try {
        $sql = "SELECT id, nome FROM projetos";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $th) {
        die("Erro ao consultar projetos: " . $th->getMessage());
    }
}

$mensagem = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $descricao = $_POST["descricao"];
    $inicio = $_POST["inicio"];
    $fim = $_POST["fim"];
    $idProjeto = $_POST["projeto"];

    if (alterarAtividade($id, $descricao, $inicio, $fim, $idProjeto)) {
        $mensagem = true;
    } else {
        $mensagem = false;
    }

    $atividade = consultarAtividade($id);
} else {
    $atividade = consultarAtividade($_GET['id']);
}

$projetos = retornarProjetos();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 bg-white rounded-4 shadow p-5">

            <h3 class="mb-4 text-center">Alterar Atividade</h3>

            <?php if ($mensagem === true): ?>
                <div class="alert alert-danger mt-3 mb-3">
                    Dados Alterados com Sucesso!
                </div>
            <?php elseif ($mensagem === false): ?>
                <div class="alert alert-warning mt-3 mb-3">
                    Nenhuma alteração foi realizada.
                </div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="id" value="<?= $atividade['idAtividade'] ?>">

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição da Atividade</label>
                    <input value="<?= htmlspecialchars($atividade['descricao']) ?>" type="text" id="descricao" name="descricao" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="inicio" class="form-label">Data de Início</label>
                    <input value="<?= $atividade['inicio'] ?>" type="date" id="inicio" name="inicio" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="fim" class="form-label">Data de Fim</label>
                    <input value="<?= $atividade['fim'] ?>" type="date" id="fim" name="fim" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="projeto" class="form-label">Projeto</label>
                    <select class="form-control" id="projeto" name="projeto" required>
                        <option value="">Selecione o Projeto</option>
                        <?php foreach ($projetos as $projeto): ?>
                            <option value="<?= $projeto['id'] ?>" <?= ($projeto['id'] == $atividade['idProjeto']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($projeto['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary" style="width: 48%;">Salvar</button>
                    <a href="atividades.php" class="btn btn-danger" style="width: 48%;">Cancelar</a>
                </div>
            </form>

        </div>
    </div>
</div>

<?php require_once("rodape.php"); ?>
