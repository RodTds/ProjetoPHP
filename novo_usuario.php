<?php
   require_once("conexao.php");
   if($_SERVER['REQUEST_METHOD'] == "POST"){
    try {
        $nome = $_POST['nome'];
        $email =$_POST['email'];
        $senha = password_hash( $_POST['senha'],PASSWORD_BCRYPT);// CRIPTOGRAFANDO A SENHA
        // variavel staitmant   stmt
        $stmt = $pdo->prepare("INSERT INTO usuarios(nome,email,senha) values(?,?,?)") ;
   
       if( $stmt->execute([$nome,$email,$senha])){
          echo"<p>Usuario Inserido com sucesso</p>";
          header("location: index.php?cadastro=true");
       }else{
         echo "Erro ao inserir usuario";
       }
           

    } catch (Exception $e) {
        echo"Erro ao inserir usuario".$e->getMessage();
    }
   }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>novo usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <main class="container">
    <h1>Novo Usuario!</h1>
    
        <form method="post" >
                        
                        <div class="mb-3">
                            <label for="nome" class="form-label">Informe o Nome</label>
                            <input type="text" id="nome" name="nome" class="form-control" required="">
                        </div>
                    
                        <div class="mb-3">
                            <label for="email" class="form-label">Informe o Email</label>
                            <input type="text" id="email" name="email" class="form-control" required="">
                        </div>
                    
                        <div class="mb-3">
                            <label for="senha" class="form-label">Informe a Senha</label>
                            <input type="text" id="senha" name="senha" class="form-control" required="">
                        </div>
                    
                    <button type="submit" class="btn btn-primary">Enviar</button>
        </form>      
     </main>      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>