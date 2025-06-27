<?php
require_once("cabecalho.php");
require('conexao.php');

// busca os projetos no banco SEMPRE (não só no POST)
$stmtProjetos = $pdo->query("SELECT id, nome FROM projetos ORDER BY descricao DESC");
$projetos = $stmtProjetos->fetchAll(PDO::FETCH_ASSOC);

// se for POST, realiza o cadastro da atividade
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $descricao = $_POST['descricao'];
        $idprojeto = $_POST['idprojeto'];
        $inicio = $_POST['inicio'];
        $fim = $_POST['fim'];

        // inserção no banco
        $stmt = $pdo->prepare("INSERT INTO atividades (descricao, idProjeto, inicio, fim) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$descricao, $idprojeto, $inicio, $fim])) {
            echo "<div class='alert alert-success text-center'>Atividade cadastrada com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Erro ao cadastrar atividade.</div>";
        }
    } catch (\Throwable $th) {
        echo "<div class='alert alert-danger text-center'>Erro: " . $th->getMessage() . "</div>";
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 bg-white shadow p-4 rounded mt-5">
            <h2 class="text-center mb-4">Cadastro de Atividade</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="descricao">Descrição da Atividade</label>
                    <input type="text" class="form-control rounded" id="descricao" name="descricao" required>
                </div>

                <div class="form-group">
                    <label for="idprojeto">Projeto Relacionado</label>
                    <select class="form-control rounded" id="idprojeto" name="idprojeto" required>
                        <option value="">Selecione um Projeto</option>
                        <?php foreach ($projetos as $projeto): ?>
                            <option value="<?= htmlspecialchars($projeto['id']) ?>">
                                <?= htmlspecialchars($projeto['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inicio">Data de Início</label>
                    <input type="date" class="form-control rounded" id="inicio" name="inicio" required>
                </div>

                <div class="form-group">
                    <label for="fim">Data de Fim</label>
                    <input type="date" class="form-control rounded" id="fim" name="fim" required>
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button type="submit" class="btn btn-primary btn-block">Salvar Atividade</button>
                    <a href="atividades.php" class="btn btn-danger btn-block">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once("rodape.php"); ?>
