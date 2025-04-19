<?php
require_once("cabecalho.php");
?>

<?php
function pesquisarNomeProjeto()
{
  require("conexao.php");
  try {
    if (isset($_POST['pesquisado']) && trim($_POST['pesquisado']) !== '') {
    $pesquisado = $_POST['pesquisado'];
  
      $stmt = $pdo->prepare("SELECT * FROM projetos WHERE nome LIKE ?");
      $stmt->execute(["%$pesquisado%"]); // busca parcial com LIKE
      return $stmt->fetchAll();
    }
    else{
     return[];  
    }
  } catch (Exception $th) {
    die("Erro ao consultar nome no banco: " . $th->getMessage());
  }
}
$pesquisados = pesquisarNomeProjeto()
  ?>
<h2>Projetos</h2>
<!-- Formulário de pesquisa alinhado à direita -->
<div class="d-flex justify-content-end mb-3">
  <form class="d-flex" method="post" action="">
    <input type="text" name="pesquisado" id="pesquisado" class="form-control me-2" placeholder="Pesquisar por nome"
      value="<?= isset($_GET['pesquisado']) ? htmlspecialchars($_GET['pesquisado']) : '' ?>">
    <button type="submit" class="btn btn-primary">Pesquisar</button>
  </form>
</div>
<table class="table table-hover table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Início</th>
      <th>Fim</th>
    </tr>
  </thead>
  <tbody>
    <?php
   
    foreach ($pesquisados as $c):
      // per
      ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= $c['nome'] ?></td>
        <td><?= $c['email'] ?></td>
        <td><?= $c['telefone'] ?></td>
        <td>
          <a href="alterar_voluntario.php?id=<?= $c['id'] ?>" class="btn btn-warning">Editar</a>
        </td>
      </tr>
      <?php

    endforeach;
    ?>
  </tbody>
</table>
<?php
require_once("rodape.php");
?>