<?php
require_once("cabecalho.php");
require("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $inicio = $_POST['inicio'];
        $fim = $_POST['fim'];

        $stmt = $pdo->prepare("INSERT INTO projetos(nome, descricao, inicio, fim) VALUES (?, ?, ?, ?)");

        if ($stmt->execute([$nome, $descricao, $inicio, $fim])) {
            echo '<div class="alert alert-success text-center" role="alert">Projeto cadastrado com sucesso!</div>';
        } else {
            echo '<div class="alert alert-danger text-center" role="alert">Erro ao cadastrar projeto.</div>';
        }
    } catch (Throwable $th) {
        echo '<div class="alert alert-danger text-center" role="alert">Erro: ' . $th->getMessage() . '</div>';
    }
}
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 bg-white shadow p-4 rounded mt-5">
            <h2 class="text-center mb-4">Cadastro de Projeto</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="nome">Nome do Projeto</label>
                    <input type="text" class="form-control rounded" id="nome" name="nome" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input type="text" class="form-control rounded" id="descricao" name="descricao" required>
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
                    <button type="submit" class="btn btn-primary btn-block">Salvar Projeto</button>
                    <a href="projetos.php" class="btn btn-danger btn-block">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once("rodape.php");
?>
