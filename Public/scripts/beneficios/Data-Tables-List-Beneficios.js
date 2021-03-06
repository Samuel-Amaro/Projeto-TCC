let cabecalho = new Headers();
cabecalho.append('contentType', 'application/x-www-form-urlencoded; charset=UTF-8');
//formulario, contem dados para o server
let form = new FormData();
form.append('operacao', 'listar');
//inicialização da api fecht informações para o servidor
const minhaInicializacao = {
    method: 'POST', //Method HTTP
    headers: cabecalho, //cabecalho http
    body: form //corpo da requisição
};
//inicializa tabela datables com ajax, sem usar jquery, somente com API nativas
let tabela = new DataTable('#dataTablesListBeneficios',{
    "responsive": true,
    "scrollX": true,
    "language": {
        "emptyTable": "Não ha beneficios cadastrados no momento"
    },
    "ajax": function(dados, callback) {
        fetch('../controller/ControllerBeneficio.php', minhaInicializacao).then(response => response.json()).then(data =>  callback(data));
    },//arrumar colunas que serão puxadas
    "columns": [
        {data: 'nome_tipo_beneficio'},
        {data: 'tipo_aquisicao'},
        {data: 'nome_categoria'},
        {data: 'quantidade_inicial_beneficio'}
        //{data: 'saldo'}
    ], 
    "columnDefs": [ {
        "targets": 4,
        "data": null,
        "defaultContent": "<button type=\"button\" class=\"btn btn-info-modal mr-2 p-0\" data-toggle=\"modal\" data-target=\"#modalCategoria\" data-whatever=\"@mdo\"><i class=\"fas fa-info-circle\"></i></button> <button type=\"button\" class=\"btn p-0\" target=\"self\" rel=\"next\"><i class=\"fas fa-trash-alt\"></i></button> <button type=\"button\" class=\"btn p-0 btn-timeline-mov\" data-toggle=\"modal\" data-target=\"#modalMovimentacoes\" data-whatever=\"@mdo\"><i class=\"fas fa-stream\"></i></button>"
    }]
});
//ao clicar no btn de info retorna os dados da linha clicada
$('#dataTablesListBeneficios tbody').on('click', '.btn-info-modal', function(){
    let data = tabela.row($(this).parents('tr')).data();
    mostraModalInformation();
    //console.log(data);
    carregaDadosModalInfo(data);
});

//ao clicar no btn da timeline mostra as movimentações de estoque de um beneficio
$('#dataTablesListBeneficios tbody').on('click', '.btn-timeline-mov', function(){
    let data = tabela.row($(this).parents('tr')).data();
    mostraModalTimelineMovimentacoes();
    makeRequestDadosTimeline("../controller/ControllerBeneficio.php", data.id_tipo_beneficio, "listarMovimentacoesBeneficio", data.nome_tipo_beneficio);
});

//ao clicar no btn de + ira abrir modal de criar uma movimentação no beneficio, sem associalo a uma entrega
$('#dataTablesListBeneficios tbody').on('click', '.add-movimentacao', function(){
    let data = tabela.row($(this).parents('tr')).data();
    mostraModalAddMovimentacao();
    carregaDadosModalAddMovimentacao(data);
});
