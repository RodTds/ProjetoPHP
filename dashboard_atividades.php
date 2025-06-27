<?php
require_once("cabecalho.php");

function exibirAtividades()
{
    try {
        require("conexao.php");
        $sql = "SELECT 
                    atividades.idAtividade,
                    atividades.descricao as descricao,
                    atividades.inicio as inicio,
                    atividades.fim as fim,
                    projetos.nome AS nome_projeto
                FROM atividades
                INNER JOIN projetos ON atividades.idProjeto = projetos.id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
        echo "Erro ao Consultar Banco: " . $th->getMessage();
    }
}

$atividades = exibirAtividades();
?>

<h1>Dashboard</h1>

<div style="margin-bottom: 20px;">
    <a class="btn btn-success" href="relatorio_atividades.php" target="_blank">Gerar Relatório</a>
</div>

<!-- Div para gráfico -->
<div id="chart_div" style="height: 500px;"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Atividade', 'Duração (dias)'],
            <?php 
                foreach ($atividades as $atividade): 
                    $descricao = addslashes($atividade['descricao']);
                    $projeto = addslashes($atividade['nome_projeto']);
                    $inicio = new DateTime($atividade['inicio']);
                    $fim = new DateTime($atividade['fim']);
                    $duracao = $inicio->diff($fim)->days;
                    echo "['$projeto - $descricao', $duracao],\n";
                endforeach;
            ?>
        ]);

        var options = {
            title: 'Duração das Atividades (em dias)',
            hAxis: {
                title: 'Atividades',
                slantedText: true,
                slantedTextAngle: 45
            },
            vAxis: {
                title: 'Dias'
            },
            legend: { position: 'none' }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>

<?php
require_once("rodape.php");
?>
