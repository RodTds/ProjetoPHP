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
    <input type="text" name="pesquisado" id="pesquisado" class="form-control me-2" placeholder="Digite o nome do Projeto"
      value="<?= isset($_POST['pesquisado']) ? htmlspecialchars($_POST['pesquisado']) : '' ?>">
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
      // no campo data, INICIO E FIM doi adicionado a clase
      // Datetime para formatar a data no padrao Brasileiro
      ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= $c['nome'] ?></td>
        <td><?= $data_formatada = (new DateTime($c['inicio']))->format('d/m/Y') ?></td>
        <td><?= $data_formatada = (new DateTime($c['fim']))->format('d/m/Y') ?></td>
        <td>
           <a href="alterar_projeto.php?id=<?= $c['id'] ?>"class="btn btn-warning">Editar</a>
          <a href="deletar_projeto.php?id=<?= $c['id'] ?>" class="btn btn-danger">Deletar</a>
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