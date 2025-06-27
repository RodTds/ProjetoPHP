<?php
session_start();
if (!$_SESSION['acesso']) {
  header("location: index.php?mensagem=acesso_negado");
}

function exibirAgendamentos()
{
    try {
        require("conexao.php");
        $sql = "SELECT 
        agenda.id,
        voluntarios.nome AS nomeVoluntario,
        atividades.descricao AS descricaoAtividade,
        agenda.dataAgendamento as dataAgendamento,
        agenda.hora_inicio as inicio,
        agenda.hora_fim as fim,
        agenda.observacoes as observacoes
    FROM agenda
    INNER JOIN voluntarios ON voluntarios.id = agenda.idVoluntario
    INNER JOIN atividades ON atividades.idAtividade = agenda.idAtividade";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        echo "Erro ao Consultar Agendamentos" . $th->getMessage();
    }
}

$agendamentos = exibirAgendamentos();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Relatório de Agendamentos</title>
    <style>
        /* Estilo normal (tela) */
        body {
        font-family:Arial, sans-serif;
            font-size: 14px;
            padding: 20px;
        }
        .no-print {
            display: block;
        }
        .print-button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            20px;
            cursor: pointer;
            border-radius: 4px;
        }

        /* Estilo para impressão */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                font-size: 12px;
                padding: 0;
            }
            .tabela th {
                background-color: #f0f0f0 !important;
                -webkit-print-color-adjust: exact;
            }
        }

        /* Seu CSS original */
        .titulo { text-align: center; font-size: 18px; font-weight: bold; }
        .tabela { width: 100%; border-collapse: collapse; 15px; }
        .tabela th, .tabela td { border: 1px solid #000; padding: 6px 10px; text-align: left; }
        .tabela th { background-color: #f0f0f0; }
    </style>
</head>
<body>

    <!-- Botão para impressão (não aparece no PDF) -->
    <button class="print-button no-print" onclick="window.print()">Imprimir / Salvar como PDF</button>

    <div class="titulo">Relatório de Agendamentos</div>
    <div class="row">
        <div class="col">Data: <?php echo date('d/m/Y'); ?></div> <!--Daonde vem essa data -->
    </div>

    <table class="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Voluntario</th>
                <th>Atividade</th>
                <th>Data</th>
                <th>Inicio</th>
                <th>Fim</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($agendamentos as $p):?>
            <tr>
                <td><?= $p['id']?></td>
                <td><?= $p['nomeVoluntario']?></td>
                <td><?= $p['descricaoAtividade']?></td>
                <td><?= $p['dataAgendamento']?></td>
                <td><?= $p['inicio']?></td>
                <td><?= $p['fim']?></td>
                <td><?= $p['observacoes']?></td>
            </tr>
             <?php endforeach;?>
            <!-- Adicione mais linhas dinamicamente com PHP -->
        </tbody>
    </table>
   <button  class="print-button no-print"  onclick="window.location.href='dashboard_atividades.php'" >Voltar</button>
    <script>
        // Opcional: Configuração para melhor experiência de impressão
        function beforePrint() {
            console.log("Preparando para impressão...");
        }
        function afterPrint() {
            console.log("Impressão concluída");
        }
        window.addEventListener('beforeprint', beforePrint);
        window.addEventListener('afterprint', afterPrint);
    </script>
</body>
</html>