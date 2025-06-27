<?php
require_once("conexao.php");
$mensagem = ""; // mensagem padrão

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    try {
        // Verifica se o email já existe
        $verifica = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $verifica->execute([$email]);
        $existe = $verifica->fetchColumn();

        if ($existe > 0) {
            $mensagem = "<div class='alert alert-warning mt-3'>Este e-mail já está cadastrado.</div>";
        } else {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, $senha]);

            if ($stmt->rowCount() > 0) {
                $mensagem = "<div class='alert alert-success mt-3'>Usuário cadastrado com sucesso!</div>";
            } else {
                $mensagem = "<div class='alert alert-danger mt-3'>Erro ao cadastrar usuário.</div>";
            }
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $mensagem = "<div class='alert alert-danger mt-3'>E-mail já está em uso. (Erro 23000)</div>";
        } else {
            $mensagem = "<div class='alert alert-danger mt-3'>Erro: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Novo Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        background-color: #f0f2f5;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .form-box {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
      }
    </style>
  </head>
  <body>
 
    <div class="form-box">
      <h2 class="text-center mb-4">Novo Usuário</h2>
      <?= $mensagem ?>
      <form method="post">
        <div class="mb-3">
          <label for="nome" class="form-label">Informe o Nome</label>
          <input type="text" id="nome" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Informe o Email</label>
          <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="senha" class="form-label">Informe a Senha</label>
          <input type="password" id="senha" name="senha" class="form-control" required>
        </div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary">Enviar</button>
          <a href="principal.php" class="btn btn-danger">Cancelar</a>
        </div>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
