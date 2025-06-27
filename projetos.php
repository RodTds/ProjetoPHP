<?php
require_once("cabecalho.php");
function retornaProjetos()
{
  require('conexao.php');
  try {
    $sql = "SELECT * FROM projetos"; // 
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(); // pega toso registro do banco de dados e retorna como array

  } catch (Exception $th) {
    die("Erro ao consultar categorias: " . $th->getMessage());
  }
}
$projetos = retornaProjetos(); // variavel recebe o retorno da função que sao todos registro da tabela categorias
?>

<h2>Projetos</h2>
<div class="d-flex justify-content-between mb-3">
<a href="novo_projeto.php" class="btn btn-success mb-3">Novo Registro</a>
<div class="ms-auto">
  <a href="pesquisar_projeto.php" class="btn btn-primary">Pesquisar</a>
</div>
</div>
<table class="table table-hover table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>NOME</th>
      <th>DESCRIÇÂO</th>
      <th>INÍCIO</th>
      <th>FIM</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($projetos as $c): // per
    ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= $c['nome'] ?></td>
        <td><?= $c['descricao'] ?></td>
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