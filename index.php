<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Controle de Estoque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        background-color: #f8f9fa;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .login-container {
        background-color: #fff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
      }
    </style>
  </head>
  <body background="tema.jpeg">
    <div class="login-container">
      <h2 class="text-center mb-4">Sistema de controle ONG</h2>

      <?php 
        require_once('conexao.php');
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
          try {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
            $stmt->execute([$email]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($usuario && password_verify($senha, $usuario['senha'])) {
              session_start();
              $_SESSION['usuario'] = $usuario['nome'];
              $_SESSION['acesso'] = true;
              header('location: principal.php');
            } else {
              $mensagem['erro'] = "Usuário e/ou senha incorretos.";
            }
          } catch (Exception $e) {
            echo $e->getMessage();
            die();
          }
        }
      ?>

      <?php if (isset($mensagem['erro'])): ?>
        <div class="alert alert-danger mt-3 mb-3">
          <?= $mensagem['erro'] ?>
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['mensagem']) && $_GET['mensagem'] == "acesso_negado"): ?>
        <div class="alert alert-danger mt-3 mb-3">
          Você precisa informar seus dados de acesso para acessar o sistema!
        </div>
      <?php endif; ?>

      <form action="" method="post">
        <div class="mb-3">
          <label for="email" class="form-label">Informe o email</label>
          <input type="text" id="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
          <label for="senha" class="form-label">Informe a senha</label>
          <input type="password" id="senha" name="senha" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100">Acessar</button>

        <div class="text-center mt-3"><b>
          Não possui acesso?</b> Clique <a href="novo_usuario.php">aqui</a>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
