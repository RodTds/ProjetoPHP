<?php
  require_once("cabecalho.php");
  require_once("conexao.php");

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];

        $stmt = $pdo->prepare("INSERT INTO voluntarios(nome, email, telefone) VALUES (?, ?, ?)");

        if ($stmt->execute([$nome, $email, $telefone])) {
            echo '<div class="alert alert-success text-center" role="alert">Usuário inserido com sucesso!</div>';
        } else {
            echo '<div class="alert alert-danger text-center" role="alert">Erro ao inserir usuário.</div>';
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger text-center" role="alert">Erro ao inserir usuário: ' . $e->getMessage() . '</div>';
    }
  }
?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 bg-white shadow p-4 rounded mt-5">
      <h2 class="text-center mb-4">Cadastro Voluntário</h2>
      <form action="" method="POST">
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="text" class="form-control rounded" id="nome" name="nome" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control rounded" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="telefone">Telefone</label>
          <input type="tel" class="form-control rounded" id="telefone" name="telefone" required>
        </div>
        <div class="d-grid gap-2 mt-3">
          <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
          <a href="voluntarios.php" class="btn btn-danger btn-block">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php
  require_once("rodape.php");
?>
