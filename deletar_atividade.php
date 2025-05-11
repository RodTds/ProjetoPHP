<?php
ob_start(); // PERGUNTAR PARA PROFESSORA E O DO FIM DA PAGINA TAMBEM
require("cabecalho.php");

function consultarAtividade($id)
{
    require("conexao.php");
        try{
        $sql = "SELECT a.idAtividade,a.descricao,p.nome AS nome,a.inicio,a.fim
         FROM atividades a
         INNER JOIN projetos p ON a.idProjeto = p.id
         WHERE a.idAtividade = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);  
        }catch(PDOException $e) {
        echo"Erro ao consultar Banco Tabela atividades".$e->getMessage();  
        }
}

function excluirAtividade($id)
{
    require_once("conexao.php");
    try {
        $sql = "DELETE FROM atividades WHERE idAtividade = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id])) {
            header('location: atividades.php');
        } else {
            header('location: atividades.php');
        }
    } catch (PDOException $th) {
        if ($th->getCode() === '23000') {
            die('<div style="color: red; background-color: #ffe6e6; padding: 15px; border: 1px solid red; border-radius: 5px;">
                    <strong>Erro:</strong> Não é possível excluir a atividade porque ela está relacionada a outro registro.
                    <br><a class="btn btn-primary" href="atividades.php">Voltar</a>
                </div>');
        } else {
            die('<div style="color: red;">Erro ao Excluir Atividade: ' . $th->getMessage() . '</div>');
        }
    }
    
    
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_POST['id'] ;
  excluirAtividade($id);
}else{
$resultados = consultarAtividade( $_GET['id']);
}
?>

<style>
    .centered-wrapper {
        background-color: #f0f2f5;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        flex-direction: column;
    }

    .form-container {
        background-color: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
    }

    h2 {
        text-align: center; /* Centralizando o título */
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 12px;
        text-align: left;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2; /* Cinza claro */
    }

    tr:nth-child(odd) {
        background-color: #fff; /* Branco */
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        width: 100%;
        border-radius: 5px;
        font-size: 16px;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
</style>

<div class="centered-wrapper">
<div class="form-container" style="margin-bottom: 20px;">
        <h2>Excluir Atividades</h2>
    </div>
    <form method="post" class="form-container">
        <table>
            <tr>
                <th>ID</th>
                <td><input value="<?= $resultados['idAtividade'] ?>" type="text" id="id" name="id" class="form-control" readonly></td>
            </tr>
            <tr>
                <th>DESCRIÇÃO</th>
                <td><input value="<?= $resultados['descricao'] ?>" type="text" id="descricao" name="descricao" class="form-control" readonly></td>
            </tr>
            <tr>
                <th>PROJETO</th>
                <td><input value="<?= $resultados['nome'] ?>" type="text" id="idprojeto" name="idprojeto" class="form-control" readonly></td>
            </tr>
            <tr>
                <th>INÍCIO</th>
                <td><input value="<?= (new DateTime($resultados['inicio']))->format('d/m/Y') ?>" type="text" id="inicio" name="inicio" class="form-control" readonly></td>
            </tr>
            <tr>
                <th>FIM</th>
                <td><input value="<?= (new DateTime($resultados['fim']))->format('d/m/Y') ?>" type="text" id="fim" name="fim" class="form-control" readonly></td>
            </tr>
        </table>
        <button type="submit" class="btn btn-danger">Deletar</button>
        <a href="atividades.php" class="btn btn-primary" style="margin-top: 10px; display: block; text-align: center;">
    Cancelar
</a>
    </form>
</div>

<?php
ob_end_flush(); 
require("rodape.php");
?>
