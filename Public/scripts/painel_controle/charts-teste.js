//REQUEST AJAX PARA DATA CHART BAR
makeRequestFecht("../controller/ControllerMovimentacoesEstoque.php", "requestDataSearch").then(function(json) {
    let valoresChart = [];
    valoresChart.push(json.data[0].qtd_total_entrada);
    valoresChart.push(json.data[0].qtd_total_saida);
    valoresChart.push(json.data[0].saldo_atual_estoque);
    let backgroundArco = [];
    for(let index = 0; index < valoresChart.length; index++){
        backgroundArco.push('rgb(' + random(0, 255) + ',' + random(0, 255) + ',' + random(0, 255) + ')');
    }
    geraChartBar(valoresChart, backgroundArco);
    console.log(backgroundArco);
}).catch(function(e) {
    console.error("HTTP RESPONSE: erro ao buscar dados para chart bar");
    console.log(e.name);
    console.log(e.message);
});

//REQUEST AJAX PARA DATA CHART PIE
makeRequestFecht("../controller/ControllerTipoBeneficio.php", "requestDataChartPie").then(function(json) {
    let labels = [];
    let valores = [];
    let backgroundArco = [];
    json.data.forEach(element => {
        labels.push(element.nome_categoria);
        valores.push(element.qtd_beneficio_categoria);
    });
    for(let index = 0; index < valores.length; index++){
        backgroundArco.push('rgb(' + random(0, 255) + ',' + random(0, 255) + ',' + random(0, 255) + ')');
    }
    geraChartPie(labels, valores, backgroundArco);
}).catch(function(e) {
    console.error("HTTP RESPONSE: erro ao buscar dados para chart PIE");
    console.log(e.name);
    console.log(e.message);
});

//renderizar grafico
//Para criar um gráfico, precisamos instanciar a Chart classe.
function geraChartBar(valores, colorsArco) {
    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, {
        type: 'bar', //grafico tipo barra vertical
        data: {
            labels: ['Entrada', 'Saida', 'Saldo'], //cada label representa uma barra
            datasets: [{
                label: 'Movimentação estoque benefícios',
                data: valores, //cada valor e o valor de cada barra
                backgroundColor: colorsArco,
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function geraChartPie(labels, valores, colorsArco) {
    const canvasChartPizza = document.getElementById('chartPizza');
    const dadosChartPie = {
        labels: labels,
        datasets: [{
        label: 'Benefícios por categoria',
        data: valores,
        backgroundColor: colorsArco,
        hoverOffset: 4
        }]
    };
    const configChartPie = {
        type: 'pie',
        data: dadosChartPie,
    };

    const myChart = new Chart(canvasChartPizza, configChartPie);
}

function random(min, max) {
    const num = Math.floor(Math.random() * (max - min + 1)) + min;
    return num;
}