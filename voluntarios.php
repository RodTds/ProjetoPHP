<?php
require_once("cabecalho.php");
function retornaVoluntarios()
{
  require('conexao.php');
  try {
    $sql = "SELECT * FROM voluntarios"; // 
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(); // pega toso registro do banco de dados e retorna como array

  } catch (Exception $th) {
    die("Erro ao consultar categorias: " . $th->getMessage());
  }
}
$voluntarios = retornaVoluntarios(); // variavel recebe o retorno da função que sao todos registro da tabela categorias
?>
<h2>Voluntarios</h2>
<div class="d-flex justify-content-between mb-3">
  <div>
    <a href="novo_voluntario.php" class="btn btn-primary me-2">Novo Registro</a>
    <a href="principal.php" class="btn btn-secondary">Voltar</a>
  </div>
  <div class="ms-auto">
    <a href="pesquisar_voluntario.php" class="btn btn-primary">Pesquisar</a>
  </div>
</div>


<table class="table table-hover table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Email</th>
      <th>Telefone</th>
    </tr>
  </thead>
  <tbody>
    <?php
        foreach ($voluntarios as $c): // per
      ?>
      <tr>
        <td><?= $c['id'] ?></td>
        <td><?= $c['nome'] ?></td>
        <td><?= $c['email'] ?></td>
        <td><?= $c['telefone'] ?></td>
        <td>
          <a href="alterar_voluntario.php?id=<?= $c['id'] ?>" class="btn btn-warning">Editar</a>
          <a href="" class="btn btn-danger">Deletar</a>
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