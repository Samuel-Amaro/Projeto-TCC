makeRequestCharts("../controller/ControllerBeneficio.php", "dataChart");
let resposta = getDados();
console.log(dados);

//renderizar grafico
//Para criar um gráfico, precisamos instanciar a Chart classe.
const ctx = document.getElementById('myChart');
const myChart = new Chart(ctx, {
    type: 'bar', //grafico tipo barra vertical
    data: {
        labels: ['Alimenticia', 'Entreterimento', 'Nova Categoria', 'Saude', 'Vestimenta'], //cada label representa uma barra
        datasets: [{
            label: 'Categoria de benefícios',
            data: [5, 2, 2, 2, 5], //cada valor e o valor de cada barra
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
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

