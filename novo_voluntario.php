<?php
  require_once("cabecalho.php");
?>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulário de Cadastro</title>
  <!-- Link para o CSS do Bootstrap -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Remover qualquer padding ou margem do body */
    body {
      background-color: #f8f9fa;
     
    }
 
    /* Container para o formulário */
    .form-container {
      
      background-color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 30px;
      border-radius: 8px;
      margin-top: 80px;  /* Ajuste para que o conteúdo fique abaixo do cabeçalho fixo */
    }

    .form-container h2 {
      margin-bottom: 20px;
    }

    .form-control {
      border-radius: 5px;
    }

    .btn-custom {
      background-color: #007bff;
      color: white;
      border-radius: 5px;
    }

    .btn-custom:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<?php
   require_once("conexao.php");
   if($_SERVER['REQUEST_METHOD'] == "POST"){
    try {
        $nome = $_POST['nome'];
        $email =$_POST['email'];
        $teledone = $_POST['telefone'];
        // variavel staitmant   stmt
        $stmt = $pdo->prepare("INSERT INTO voluntarios(nome,email,telefone) values(?,?,?)") ;
   
       if( $stmt->execute([$nome,$email,$teledone])){
               echo"<p>Usuario Inserido com sucesso</p>";
       }else{
         echo "Erro ao inserir usuario";
       }
    } catch (Exception $e) {
        echo"Erro ao inserir usuario".$e->getMessage();
    }
   }
?>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 form-container">
        <h2 class="text-center">Cadastro Voluntário</h2>
        <form action="" method="POST">
          <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="tel" class="form-control" id="telefone" name="telefone" required>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-custom btn-block">Cadastrar</button>
            <a href="voluntarios.php" type="button" class="btn btn-danger">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Scripts do Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
  require_once("rodape.php");
?>
